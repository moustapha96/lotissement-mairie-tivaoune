<?php

namespace App\Controller;

use App\Entity\Lotissement;
use App\Form\LotissementType;
use App\Repository\LotissementRepository;
use App\Repository\ParcelleRepository;
use App\Repository\PlanRepository;
use App\Repository\StatutLotissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('demandeur/lotissements')]
class LotissementClientController extends AbstractController
{
    #[Route('/', name: 'client_lotissement_app_index', methods: ['GET'])]
    public function index(LotissementRepository $lotissementRepository): Response
    {
        return $this->render('client/lotissement_app/index.html.twig', [
            'lotissements' => $lotissementRepository->findAll(),
        ]);
    }



    #[Route('/{id}/parcelles', name: 'client_lotissement_parcelle_app_index', methods: ['GET'])]
    public function parcelles(Lotissement $lotissement, ParcelleRepository $parcelleRepository): Response
    {

        $parcelles = $parcelleRepository->findBy(['lotissement' => $lotissement]);
        return $this->render('client/lotissement_app/parcelle.html.twig', [
            'lotissement' => $lotissement,
            'parcelles' => $parcelles
        ]);
    }



    #[Route('/{id}/demandes', name: 'client_lotissement_demande_app_index', methods: ['GET'])]
    public function demandes(
        Lotissement $lotissement,
        StatutLotissementRepository $statutLotissementRepository
    ): Response {
        return $this->render('client/lotissement_app/demande.html.twig', [
            'lotissement' => $lotissement,
            'demandes' =>  $lotissement->getDemandes(),
            'status' =>  $statutLotissementRepository->findAll(),
        ]);
    }


    #[Route('/{id}/plans', name: 'client_lotissement_plan_app_index', methods: ['GET'])]
    public function plans(Lotissement $lotissement, PlanRepository $planRepository): Response
    {

        return $this->render('client/lotissement_app/plan.html.twig', [
            'lotissement' => $lotissement,
            'plans' =>  $lotissement->getPlans()
        ]);
    }


    #[Route('/new', name: 'client_lotissement_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $lotissement = new Lotissement();
        $form = $this->createForm(LotissementType::class, $lotissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($lotissement);
            $entityManager->flush();

            return $this->redirectToRoute('client_lotissement_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/lotissement_app/new.html.twig', [
            'lotissement' => $lotissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'client_lotissement_app_show', methods: ['GET'])]
    public function show(Lotissement $lotissement): Response
    {
        return $this->render('client/lotissement_app/show.html.twig', [
            'lotissement' => $lotissement,
        ]);
    }

    #[Route('/{id}/edit', name: 'client_lotissement_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Lotissement $lotissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LotissementType::class, $lotissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('client_lotissement_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/lotissement_app/edit.html.twig', [
            'lotissement' => $lotissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'client_lotissement_app_delete', methods: ['POST'])]
    public function delete(Request $request, Lotissement $lotissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $lotissement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($lotissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('client_lotissement_app_index', [], Response::HTTP_SEE_OTHER);
    }
}