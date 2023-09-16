<?php

namespace App\Controller;

use App\Entity\Parcelle;
use App\Form\ParcelleType;
use App\Repository\ParcelleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('parcelles')]
class ParcelleAppController extends AbstractController
{
    #[Route('/', name: 'app_parcelle_app_index', methods: ['GET'])]
    public function index(ParcelleRepository $parcelleRepository): Response
    {
        return $this->render('admin/parcelle_app/index.html.twig', [
            'parcelles' => $parcelleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_parcelle_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parcelle = new Parcelle();
        $form = $this->createForm(ParcelleType::class, $parcelle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($parcelle);
            $entityManager->flush();

            return $this->redirectToRoute('app_parcelle_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/parcelle_app/new.html.twig', [
            'parcelle' => $parcelle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parcelle_app_show', methods: ['GET'])]
    public function show(Parcelle $parcelle): Response
    {
        return $this->render('admin/parcelle_app/show.html.twig', [
            'parcelle' => $parcelle,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parcelle_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parcelle $parcelle, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParcelleType::class, $parcelle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_parcelle_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/parcelle_app/edit.html.twig', [
            'parcelle' => $parcelle,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parcelle_app_delete', methods: ['POST'])]
    public function delete(Request $request, Parcelle $parcelle, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $parcelle->getId(), $request->request->get('_token'))) {
            $entityManager->remove($parcelle);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parcelle_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
