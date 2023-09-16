<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\College;
use App\Entity\Rapport;
use App\Form\CollegeType;
use App\Form\RapportType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CollegeRepository;
use App\Repository\DemandeRepository;
use App\Repository\DemandeurRepository;
use App\Repository\LocaliteRepository;
use App\Repository\LotissementRepository;
use App\Repository\ParcelleRepository;
use App\Repository\PlanRepository;
use App\Repository\RapportRepository;
use App\Repository\UserRepository;
use App\Service\MailerService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Route('/admin',  name: "admin_")]
// #[AttributeIsGranted("ROLE_ADMIN", statusCode: 404, message: "Page non accéssible")]
class AdminController extends AbstractController
{

    public function __construct()
    {
    }


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

        return $this->render("admin/dashboard/index.html.twig", [
            'titre' => 'Accueil Administrateur',
            'demandes' => $demandeRepository->findAll(),
            'demandeurs' => $demandeurRepository->findAll(),
            'parcelles' => $parcelleRepository->findAll(),
            'plans' => $planRepository->findAll(),
            'localites' => $localiteRepository->findAll(),
            'lotissements' => $lotissementRepository->findAll(),
            'users' =>  $userRepository->findAll()
        ]);
    }
}
