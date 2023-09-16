<?php

namespace App\Controller;

use App\Entity\Plan;
use App\Form\PlanType;
use App\Repository\PlanRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

#[Route('plans')]
class PlanAppController extends AbstractController
{
    #[Route('/', name: 'app_plan_app_index', methods: ['GET'])]
    public function index(PlanRepository $planRepository): Response
    {
        return $this->render('admin/plan_app/index.html.twig', [
            'plans' => $planRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_plan_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $plan = new Plan();
        $form = $this->createForm(PlanType::class, $plan);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $fichiers = [];

            $files = $form->get('fichier')->getData();

            foreach ($files as $file) {
                if ($file instanceof UploadedFile) {
                    $fileName = count($fichiers) . $file->getFilename() . '.' . $file->guessExtension();
                    $file->move($this->getParameter('plan_directory'), $fileName);
                    $fichiers[] = $fileName;
                }
            }

            $plan->setFichier($fichiers);
            $entityManager->persist($plan);
            $entityManager->flush();

            return $this->redirectToRoute('app_plan_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/plan_app/new.html.twig', [
            'plan' => $plan,
            'form' => $form->createView(), // Assurez-vous d'utiliser createView() pour passer le formulaire au modèle Twig
        ]);
    }


    // public function new(Request $request, EntityManagerInterface $entityManager): Response
    // {
    //     $plan = new Plan();
    //     $form = $this->createForm(PlanType::class, $plan);
    //     $form->handleRequest($request);

    //     if ($form->isSubmitted() && $form->isValid()) {

    //         $files = $form->get('fichier')->getData();

    //         foreach ($files as $file) {

    //             if ($file instanceof UploadedFile) {
    //                 $fileName = strtotime('now') . '.' . $file->guessExtension();
    //                 $file->move($this->getParameter('plans_directory'), $fileName);
    //                 $fichiers[] = $fileName;
    //             }
    //         }

    //         $plan->setFichier($fichiers);
    //         $entityManager->persist($plan);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('app_plan_app_index', [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render('admin/plan_app/new.html.twig', [
    //         'plan' => $plan,
    //         'form' => $form,
    //     ]);
    // }

    #[Route('/{id}', name: 'app_plan_app_show', methods: ['GET'])]
    public function show(Plan $plan): Response
    {
        return $this->render('admin/plan_app/show.html.twig', [
            'plan' => $plan,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_plan_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Plan $plan, EntityManagerInterface $entityManager): Response
    {

        $fichiers = $plan->getFichier();
        $form = $this->createForm(PlanType::class, $plan);
        $form->handleRequest($request);


        if ($form->isSubmitted()) {

            $files = $form->get('fichier')->getData();

            foreach ($files as $file) {

                if ($file instanceof UploadedFile) {

                    $fileName = count($fichiers) . $file->getFilename() . '.' . $file->guessExtension();
                    $file->move($this->getParameter('plan_directory'), $fileName);
                    $fichiers[] = $fileName;
                }
            }

            $plan->setFichier($fichiers);
            $entityManager->flush();

            return $this->redirectToRoute('app_plan_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/plan_app/edit.html.twig', [
            'plan' => $plan,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_plan_app_delete', methods: ['POST'])]
    public function delete(Request $request, Plan $plan, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $plan->getId(), $request->request->get('_token'))) {
            $entityManager->remove($plan);
            $entityManager->flush();
            $this->addFlash('success', "Plan suppprimer avec succés ");
        }

        return $this->redirectToRoute('app_plan_app_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/{id}/statut', name: 'app_plan_statut_app_update', methods: ['GET'])]
    public function changeStatut(Plan $plan, EntityManagerInterface $entityManager): Response
    {
        $plan->setStatut(!$plan->isStatut());
        $entityManager->persist($plan);
        $entityManager->flush();
        $plan->isStatut()  == true ?  $this->addFlash('success', "Statut activé avec succés ") :  $this->addFlash('warning', "Statut desactivé avec succés ");
        return $this->redirectToRoute('app_plan_app_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/{id}/{fichier}/fichier', name: 'app_plan_file_app_delete', methods: ['GET'])]
    public function deleteFile(Plan $plan, String $fichier, EntityManagerInterface $entityManager): Response
    {
        $fichiers = $plan->getFichier();
        $po = null;

        foreach ($fichiers as $key => $value) {
            if ($fichier == $value) {
                $po = $key;
                break;
            }
        }
        if ($po !== null) {
            array_splice($fichiers, $po, 1);
            $filePath = $this->getParameter('plan_directory') . '/' . $fichier;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $plan->setFichier($fichiers);
        }

        $plan->setFichier($fichiers);
        $entityManager->persist($plan);
        $entityManager->flush();
        $this->addFlash('success', "Fichier suppprimer avec succés ");
        return $this->redirectToRoute('app_plan_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
