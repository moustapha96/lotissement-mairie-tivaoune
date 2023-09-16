<?php

namespace App\Controller;

use App\Entity\StatutLotissement;
use App\Form\StatutLotissementType;
use App\Repository\StatutLotissementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statut/lotissement/app')]
class StatutLotissementAppController extends AbstractController
{
    #[Route('/', name: 'app_statut_lotissement_app_index', methods: ['GET'])]
    public function index(StatutLotissementRepository $statutLotissementRepository): Response
    {
        return $this->render('admin/statut_lotissement_app/index.html.twig', [
            'statut_lotissements' => $statutLotissementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_statut_lotissement_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $statutLotissement = new StatutLotissement();
        $form = $this->createForm(StatutLotissementType::class, $statutLotissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($statutLotissement);
            $entityManager->flush();

            return $this->redirectToRoute('app_statut_lotissement_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/statut_lotissement_app/new.html.twig', [
            'statut_lotissement' => $statutLotissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statut_lotissement_app_show', methods: ['GET'])]
    public function show(StatutLotissement $statutLotissement): Response
    {
        return $this->render('admin/statut_lotissement_app/show.html.twig', [
            'statut_lotissement' => $statutLotissement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_statut_lotissement_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, StatutLotissement $statutLotissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatutLotissementType::class, $statutLotissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_statut_lotissement_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/statut_lotissement_app/edit.html.twig', [
            'statut_lotissement' => $statutLotissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statut_lotissement_app_delete', methods: ['POST'])]
    public function delete(Request $request, StatutLotissement $statutLotissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $statutLotissement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($statutLotissement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_statut_lotissement_app_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/statut', name: 'app_statut_lotissement_statut_app_update', methods: ['GET'])]
    public function changeStatut(
        StatutLotissement $statutLotissement,
        EntityManagerInterface $entityManager
    ): Response {

        $statutLotissement->setStatus(!$statutLotissement->isStatus());
        $entityManager->persist($statutLotissement);
        $entityManager->flush();

        $statutLotissement->isStatus()  == true ?  $this->addFlash('success', "Statut activé avec succés ") :  $this->addFlash('warning', "Statut desactivé avec succés ");
        return $this->redirectToRoute('app_statut_lotissement_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
