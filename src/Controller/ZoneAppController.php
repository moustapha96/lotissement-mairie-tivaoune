<?php

namespace App\Controller;

use App\Entity\Zone;
use App\Form\ZoneType;
use App\Repository\ZoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/zones')]
class ZoneAppController extends AbstractController
{
    #[Route('/', name: 'app_zone_app_index', methods: ['GET'])]
    public function index(ZoneRepository $zoneRepository): Response
    {
        return $this->render('admin/zone_app/index.html.twig', [
            'zones' => $zoneRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_zone_app_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $zone = new Zone();
        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($zone);
            $entityManager->flush();

            return $this->redirectToRoute('app_zone_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/zone_app/new.html.twig', [
            'zone' => $zone,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_zone_app_show', methods: ['GET'])]
    public function show(Zone $zone): Response
    {
        return $this->render('admin/zone_app/show.html.twig', [
            'zone' => $zone,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_zone_app_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Zone $zone, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ZoneType::class, $zone);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_zone_app_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/zone_app/edit.html.twig', [
            'zone' => $zone,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_zone_app_delete', methods: ['POST'])]
    public function delete(Request $request, Zone $zone, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $zone->getId(), $request->request->get('_token'))) {
            $entityManager->remove($zone);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_zone_app_index', [], Response::HTTP_SEE_OTHER);
    }
}
