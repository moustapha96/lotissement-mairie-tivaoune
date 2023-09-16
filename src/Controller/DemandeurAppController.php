<?php

namespace App\Controller;

use App\Entity\Demandeur;
use App\Form\DemandeurType;
use App\Repository\DemandeRepository;
use App\Repository\DemandeurRepository;
use App\Repository\StatutLotissementRepository;
use App\Repository\StatutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/demandeurs')]
class DemandeurAppController extends AbstractController
{
    #[Route('/', name: 'app_demandeur_app_index', methods: ['GET'])]
    public function index(DemandeurRepository $demandeurRepository, StatutRepository $statutRepository): Response
    {
        return $this->render('admin/demandeur_app/index.html.twig', [
            'demandeurs' => $demandeurRepository->findAll(),
            'statuts' => $statutRepository->findBy(['status' => 1])
        ]);
    }



    #[Route('/{id}/demandes', name: 'app_demandeur_demande_app_index', methods: ['GET'])]
    public function demandesDemandeur(
        Demandeur $demandeur,
        DemandeRepository $demandeRepository,
        StatutLotissementRepository $statutLotissementRepository
    ): Response {
        $demandes = $demandeRepository->findBy(['demandeur' => $demandeur]);
        return $this->render('admin/demandeur_app/demande.html.twig', [
            'demandes' => $demandes,
            'demandeur' => $demandeur,
            'status' =>  $statutLotissementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_demandeur_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $demandeur = new Demandeur();
        $form = $this->createForm(DemandeurType::class, $demandeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($demandeur);
            $entityManager->flush();

            $this->addFlash('success', "Demandeur créé avec succés ");
            return $this->redirectToRoute('app_demandeur_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/demandeur_app/new.html.twig', [
            'demandeur' => $demandeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demandeur_app_show', methods: ['GET'])]
    public function show(Demandeur $demandeur): Response
    {
        return $this->render('admin/demandeur_app/show.html.twig', [
            'demandeur' => $demandeur,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_demandeur_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Demandeur $demandeur, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DemandeurType::class, $demandeur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', "Demandeur mise à jour avec succés ");
            return $this->redirectToRoute('app_demandeur_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/demandeur_app/edit.html.twig', [
            'demandeur' => $demandeur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demandeur_app_delete', methods: ['POST'])]
    public function delete(Request $request, Demandeur $demandeur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $demandeur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($demandeur);
            $entityManager->flush();
            $this->addFlash('success', "Demandeur supprimé avec succés ");
        }

        return $this->redirectToRoute('app_demandeur_app_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/statut/{id}', name: 'app_demandeur_statut_app_update', methods: ['GET', 'POST'])]
    public function changestatut(
        Request $request,
        EntityManagerInterface $entityManager,
        Demandeur $demandeur,
        StatutRepository $statutRepository
    ): Response {

        $statut = $statutRepository->find($request->request->all()['statut']);
        $demandeur->setStatut($statut);
        $entityManager->persist($demandeur);
        $entityManager->flush();
        $this->addFlash('success', "Statut demandeur mise à jour avec succès ");
        return $this->redirect($request->headers->get('referer'));

        // return $this->redirectToRoute('app_demande_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
