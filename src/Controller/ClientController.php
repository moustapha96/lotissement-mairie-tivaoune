<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\DemandeRepository;
use App\Repository\DemandeurRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LocaliteRepository;
use App\Repository\LotissementRepository;
use App\Repository\ParcelleRepository;
use App\Repository\PlanRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted as AttributeIsGranted;


#[Route('/client',  name: "client_")]
#[AttributeIsGranted("ROLE_USER", statusCode: 404, message: "Page non accéssible")]
class ClientController extends AbstractController
{


    #[Route('/',  name: "home")]
    public function index(
        DemandeRepository $demandeRepository,
        UserRepository $userRepository,
        DemandeurRepository $demandeurRepository,
        ParcelleRepository $parcelleRepository,
        PlanRepository $planRepository,
        LocaliteRepository $localiteRepository,
        LotissementRepository $lotissementRepository

    ): Response {
        $user = new User();
        $user = $this->getUser();
        $demandeur = $demandeurRepository->findOneBy(['compte' => $user]);
        return $this->render("client/dashboard/index.html.twig", [
            'titre' => 'Accueil Demandeur',
            'demandes' => $demandeur->getDemandes(),
            'parcelles' => $parcelleRepository->findAll(),
            'plans' => $planRepository->findAll(),
            'localites' => $localiteRepository->findAll(),
            'lotissements' => $lotissementRepository->findAll(),
            'users' =>  $userRepository->findAll()
        ]);
    }
}
