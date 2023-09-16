<?php

namespace App\Controller;

use App\Entity\Dimension;
use App\Form\DimensionType;
use App\Repository\DimensionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('dimensions')]
class DimensionAppController extends AbstractController
{
    #[Route('/', name: 'app_dimension_app_index', methods: ['GET'])]
    public function index(DimensionRepository $dimensionRepository): Response
    {
        return $this->render('admin/dimension_app/index.html.twig', [
            'dimensions' => $dimensionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dimension_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dimension = new Dimension();
        $form = $this->createForm(DimensionType::class, $dimension);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dimension);
            $entityManager->flush();

            return $this->redirectToRoute('app_dimension_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/dimension_app/new.html.twig', [
            'dimension' => $dimension,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dimension_app_show', methods: ['GET'])]
    public function show(Dimension $dimension): Response
    {
        return $this->render('admin/dimension_app/show.html.twig', [
            'dimension' => $dimension,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dimension_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Dimension $dimension, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DimensionType::class, $dimension);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_dimension_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/dimension_app/edit.html.twig', [
            'dimension' => $dimension,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dimension_app_delete', methods: ['POST'])]
    public function delete(Request $request, Dimension $dimension, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $dimension->getId(), $request->request->get('_token'))) {
            $entityManager->remove($dimension);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_dimension_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
