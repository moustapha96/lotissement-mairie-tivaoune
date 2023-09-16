<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Demandeur;
use App\Entity\User;
use App\Form\DemandeFormType;
use App\Repository\DemandeurRepository;
use App\Repository\LotissementRepository;
use App\Repository\StatutLotissementRepository;
use App\Repository\StatutRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    private $passwordEncoder;
    public function __construct(
        UserPasswordHasherInterface $passwordHasher,

    ) {
        $this->passwordEncoder = $passwordHasher;
    }



    #[Route('/novelle-demande', name: 'app_home_demande', methods: ['GET', 'POST'])]
    public function index(
        Request $request,
        StatutLotissementRepository $statutLotissementRepository,
        DemandeurRepository $demandeurRepository,
        LotissementRepository $lotissementRepository,
        StatutRepository $statutRepository,
        EntityManagerInterface $entityManager,
        SessionInterface $session
    ): Response {


        $referer = $request->headers->get('referer');
        $session->set('previous_page', $referer);

        $demande = new Demande();
        $demandeur = new Demandeur();
        $form = $this->createForm(DemandeFormType::class, [$demande, $demandeur]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            // verification compte demandeur
            $prenom = $data['prenom'];
            $nom = $data['nom'];
            $telephone = $data['telephone'];
            $email = $data['email'];
            $nin = $data['nin'];
            $situationMatrimoniale = $data['situationMatrimoniale'];
            $nationalite = $data['nationalite'];
            $adresse = $data['adresse'];
            $dateNaissance = $data['dateNaissance'];
            $lieuNaissance = $data['lieuNaissance'];
            $adresseResidentielle = $data['adresseResidentielle'];
            $civilite = $data['civilite'];
            $adresseResidentielle = $data['adresseResidentielle'];
            $sexe = $civilite == "M." ? "MASCULIN" : "FÉMININ";
            // dd($nationalite);
            $critere = ['email' => $email, 'nin' => $nin, 'telephone' => $telephone];
            $demandeur = $demandeurRepository->findOneBy($critere);
            if ($demandeur == null) {

                $ifDemandeur = $demandeurRepository->findOneBy(['nin' => $data['nin']]);
                if ($ifDemandeur) {
                    $this->addFlash('warning', "NIN déjà utilisé");

                    return $this->redirect($request->headers->get('referer'));
                }
                $idDemandeurTel = $demandeurRepository->findOneBy(['telephone' => $telephone]);
                if ($idDemandeurTel) {
                    $this->addFlash('warning', "Téléphone déjà utilisé");
                    return $this->redirect($request->headers->get('referer'));
                }
                $demandeur = new Demandeur();
                $demandeur->setPrenom($prenom);
                $demandeur->setNom($nom);
                $demandeur->setNin($nin);
                $demandeur->setSituationMatrimoniale($situationMatrimoniale);
                $demandeur->setNationalite($nationalite);
                $demandeur->setAdresse($adresse);
                $demandeur->setDateNaissance($dateNaissance);
                $demandeur->setLieuNaissance($lieuNaissance);
                $demandeur->setAdresseResidentielle($adresseResidentielle);
                $demandeur->setCivilite($civilite);
                $demandeur->setTelephone($telephone);
                $demandeur->setEmail($email);
                $demandeur->setStatut($statutRepository->find(1));

                $user = new User();
                $user->setAdresse($adresse);
                $user->setPhone($telephone);
                $user->setSexe($sexe);
                $user->setFirstName($prenom);
                $user->setLastName($nom);
                $user->setEmail($email);
                $user->setEnabled(true);
                $user->setStatus("ACTIVE");
                $user->setIsActiveNow(false);
                $user->setAvatar("assets/img/users/user-orig.png");
                $user->setRoles(["ROLE_USER", "ROLE_DEMANDEUR"]);
                $user->setLastActivityAt(new \DateTime('now'));
                $hashedPassword = $this->passwordEncoder->hashPassword(
                    $user,
                    $telephone
                );
                $user->setPassword($hashedPassword);
                $user->setPlainPassword($hashedPassword);
                $demandeur->setCompte($user);
                $demande->setDemandeur($demandeur);
            } else {
                $demande->setDemandeur($demandeur);
            }

            // verification demande
            $demandeAdresseMaireFile = $form->get('demandeAdresseMaire')->getData();
            if ($demandeAdresseMaireFile instanceof UploadedFile) {
                $demandeAdresseMairename = uniqid() . '.' . $demandeAdresseMaireFile->guessExtension();
                $demandeAdresseMaireFile->move($this->getParameter('pdf_directory'), $demandeAdresseMairename);
                $demande->setDemandeAdresseMaire($demandeAdresseMairename);
            }

            $cnifile = $form->get('cni')->getData();
            if ($cnifile instanceof UploadedFile) {
                $cniname = uniqid() . '.' . $cnifile->guessExtension();
                $cnifile->move($this->getParameter('pdf_directory'), $cniname);
                $demande->setCni($cniname);
            }


            $statut = $statutLotissementRepository->findOneBy(['denomination' =>  'RÉCEPTION']);
            $demande->setStatut($statut);
            $demande->setNumero(strtotime('now'));

            $entityManager->persist($demande);
            $entityManager->flush();

            $this->addFlash('success', "Demande  créé avec succés ");
            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }



        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'form' => $form->createView(),
            'titre' => "Nouvelle Demande"
        ]);
    }


    public function someAction(Request $request, SessionInterface $session)
    {
        $referer = $request->headers->get('referer');
        $session->set('previous_page', $referer);
    }
}
