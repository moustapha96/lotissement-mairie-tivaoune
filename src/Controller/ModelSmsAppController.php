<?php

namespace App\Controller;

use App\Entity\ModelSms;
use App\Form\ModelSmsType;
use App\Repository\ModelSmsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/model/sms/app')]
class ModelSmsAppController extends AbstractController
{
    #[Route('/', name: 'app_model_sms_app_index', methods: ['GET'])]
    public function index(ModelSmsRepository $modelSmsRepository): Response
    {
        return $this->render('admin/model_sms_app/index.html.twig', [
            'model_sms' => $modelSmsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_model_sms_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $modelSm = new ModelSms();
        $form = $this->createForm(ModelSmsType::class, $modelSm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($modelSm);
            $entityManager->flush();

            return $this->redirectToRoute('app_model_sms_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/model_sms_app/new.html.twig', [
            'model_sm' => $modelSm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_model_sms_app_show', methods: ['GET'])]
    public function show(ModelSms $modelSm): Response
    {
        return $this->render('admin/model_sms_app/show.html.twig', [
            'model_sm' => $modelSm,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_model_sms_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ModelSms $modelSm, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ModelSmsType::class, $modelSm);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_model_sms_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/model_sms_app/edit.html.twig', [
            'model_sm' => $modelSm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_model_sms_app_delete', methods: ['POST'])]
    public function delete(Request $request, ModelSms $modelSm, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $modelSm->getId(), $request->request->get('_token'))) {
            $entityManager->remove($modelSm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_model_sms_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
