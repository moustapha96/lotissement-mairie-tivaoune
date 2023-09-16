<?php

namespace App\Controller;

use App\Entity\Parametrage;
use App\Form\ParametrageType;
use App\Repository\ParametrageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parametrage/app')]
class ParametrageAppController extends AbstractController
{
    #[Route('/', name: 'app_parametrage_app_index', methods: ['GET'])]
    public function index(ParametrageRepository $parametrageRepository): Response
    {
        return $this->render('admin/parametrage_app/index.html.twig', [
            'parametrages' => $parametrageRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_parametrage_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parametrage = new Parametrage();
        $form = $this->createForm(ParametrageType::class, $parametrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($parametrage);
            $entityManager->flush();

            return $this->redirectToRoute('app_parametrage_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admi/nparametrage_app/new.html.twig', [
            'parametrage' => $parametrage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parametrage_app_show', methods: ['GET'])]
    public function show(Parametrage $parametrage): Response
    {
        return $this->render('parametrage_app/show.html.twig', [
            'parametrage' => $parametrage,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parametrage_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parametrage $parametrage, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParametrageType::class, $parametrage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_parametrage_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/parametrage_app/edit.html.twig', [
            'parametrage' => $parametrage,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parametrage_app_delete', methods: ['POST'])]
    public function delete(Request $request, Parametrage $parametrage, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $parametrage->getId(), $request->request->get('_token'))) {
            $entityManager->remove($parametrage);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parametrage_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
