<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Demandeur;
use App\Entity\StatutLotissement;
use App\Entity\User;
use App\Form\DemandeEditClientType;
use App\Form\DemandeEditType;
use App\Form\DemandeFormType;
use App\Form\DemandeType;
use App\Form\StatutLotiissementEditeType;
use App\Repository\DemandeRepository;
use App\Repository\DemandeurRepository;
use App\Repository\LotissementRepository;
use App\Repository\StatutLotissementRepository;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('demandeur/demandes')]
class DemandeClientController extends AbstractController
{

    private $passwordEncoder;
    public function __construct(
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,

    ) {
        $this->passwordEncoder = $passwordHasher;
    }


    #[Route('/', name: 'client_demande_app_index', methods: ['GET'])]
    public function index(DemandeRepository $demandeRepository, StatutLotissementRepository $statutLotissementRepository): Response
    {

        $user = $this->getUser();
        $demandeur = $user->getDemandeur();

        return $this->render('client/demande_app/index.html.twig', [
            'demandes' => $demandeur->getDemandes(),
            'titre' => "Liste de demandes",
            'status' =>  $statutLotissementRepository->findBy(['status' => 1]),
        ]);
    }


    #[Route('/demadeur/new', name: 'client_demande_demande_app_new', methods: ['GET', 'POST'])]
    public function newDemandeur(
        Request $request,
        EntityManagerInterface $entityManager,
        StatutLotissementRepository $statutLotissementRepository,
        DemandeurRepository $demandeurRepository,
        StatutRepository $statutRepository,
    ): Response {
        $demande = new Demande();
        $form = $this->createForm(DemandeFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
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
                $demande->setDemandeur($demandeur);

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

            $demande->setDemandeur($demandeur);
            $statut = $statutLotissementRepository->findOneBy(['denomination' =>  'RÉCEPTION']);
            $demande->setStatut($statut);
            $demande->setNumero(strtotime('now'));

            $entityManager->persist($demande);
            $entityManager->flush();


            $this->addFlash('success', "Nouvelle demande ajoutée avec succés ");
            return $this->redirectToRoute('client_demande_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/demande_app/nouvelle.html.twig', [
            'form' => $form,
        ]);
    }


    #[Route('/new', name: 'client_demande_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $demande = new Demande();
        $form = $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $demandeur = $form->get('demandeur')->getData();
            // $nin = $demandeur->getNin();
            $demande->setNumero(strtotime('now'));
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
            $entityManager->persist($demande);
            $entityManager->flush();

            $this->addFlash('success', "Demande  créé avec succés ");
            return $this->redirectToRoute('client_demande_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/demande_app/new.html.twig', [
            'demande' => $demande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'client_demande_app_show', methods: ['GET'])]
    public function show(Demande $demande): Response
    {
        return $this->render('client/demande_app/show.html.twig', [
            'demande' => $demande,
        ]);
    }

    #[Route('/{id}/edit', name: 'client_demande_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {

        $form = $this->createForm(DemandeEditClientType::class, $demande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', "Demande  mise à jour avec succés ");
            return $this->redirectToRoute('client_demande_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/demande_app/edit.html.twig', [
            'demande' => $demande,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'client_demande_app_delete', methods: ['POST'])]
    public function delete(Request $request, Demande $demande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($demande);
            $entityManager->flush();
            $this->addFlash('success', "Demande  supprimée avec succés ");
        }

        return $this->redirectToRoute('client_demande_app_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/statut/{id}', name: 'client_demande_statut_app_update', methods: ['GET', 'POST'])]
    public function changestatut(
        Request $request,
        EntityManagerInterface $entityManager,
        Demande $demande,
        StatutLotissementRepository $statutLotissementRepository
    ): Response {

        $statut = $statutLotissementRepository->find($request->request->all()['statut']);
        $demande->setStatut($statut);
        $entityManager->persist($demande);
        $entityManager->flush();
        $this->addFlash('success', "Statut demande mise à jour avec succès ");
        return $this->redirect($request->headers->get('referer'));

        // return $this->redirectToRoute('client_demande_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
