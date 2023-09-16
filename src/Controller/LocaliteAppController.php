<?php

namespace App\Controller;

use App\Entity\Localite;
use App\Form\LocaliteType;
use App\Repository\LocaliteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('localites')]
class LocaliteAppController extends AbstractController
{
    #[Route('/', name: 'app_localite_app_index', methods: ['GET'])]
    public function index(LocaliteRepository $localiteRepository): Response
    {
        return $this->render('admin/localite_app/index.html.twig', [
            'localites' => $localiteRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_localite_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $localite = new Localite();
        $form = $this->createForm(LocaliteType::class, $localite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($localite);
            $entityManager->flush();

            return $this->redirectToRoute('app_localite_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/localite_app/new.html.twig', [
            'localite' => $localite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_localite_app_show', methods: ['GET'])]
    public function show(Localite $localite): Response
    {
        return $this->render('admin/localite_app/show.html.twig', [
            'localite' => $localite,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_localite_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Localite $localite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LocaliteType::class, $localite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_localite_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/localite_app/edit.html.twig', [
            'localite' => $localite,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_localite_app_delete', methods: ['POST'])]
    public function delete(Request $request, Localite $localite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $localite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($localite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_localite_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
