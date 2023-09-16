<?php

namespace App\Controller;

use App\Entity\Statut;
use App\Form\StatutType;
use App\Repository\StatutRepository;
use Doctrine\Migrations\Version\State;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/statut')]
class StatutAppController extends AbstractController
{
    #[Route('/', name: 'app_statut_app_index', methods: ['GET'])]
    public function index(StatutRepository $statutRepository): Response
    {
        return $this->render('admin/statut_app/index.html.twig', [
            'statuts' => $statutRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_statut_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $statut = new Statut();
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($statut);
            $entityManager->flush();

            return $this->redirectToRoute('app_statut_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/statut_app/new.html.twig', [
            'statut' => $statut,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statut_app_show', methods: ['GET'])]
    public function show(Statut $statut): Response
    {
        return $this->render('admin/statut_app/show.html.twig', [
            'statut' => $statut,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_statut_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Statut $statut, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StatutType::class, $statut);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_statut_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/statut_app/edit.html.twig', [
            'statut' => $statut,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_statut_app_delete', methods: ['POST'])]
    public function delete(Request $request, Statut $statut, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $statut->getId(), $request->request->get('_token'))) {
            $entityManager->remove($statut);
            $entityManager->flush();
        }
        return $this->redirectToRoute('app_statut_app_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/statut', name: 'app_statut_statut_app_update', methods: ['GET'])]
    public function changeStatut(
        Statut $statut,
        EntityManagerInterface $entityManager
    ): Response {

        $statut->setStatus(!$statut->isStatus());
        $entityManager->persist($statut);
        $entityManager->flush();

        $statut->isStatus()  == true ?  $this->addFlash('success', "Statut activé avec succés ") :  $this->addFlash('warning', "Statut desactivé avec succés ");
        return $this->redirectToRoute('app_statut_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
