<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'titre' => "Liste des Inspecteurs"
        ]);
    }

    #[Route('/new', name: 'app_user_new', methods: ['GET', 'POST'])]
    public function new(
        UserRepository $userRepository,
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        EntityManagerInterface $entityManager
    ): Response {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setAvatar('avatar.jpeg');
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    'password'
                )
            );

            $user->setStatus("ACTIVE");

            $userByEmail = $userRepository->findOneBy(['email' => $form->getData('email')]);
            if ($userByEmail) {
                $this->addFlash('danger', 'Cette adresse email est déjà utilisé.');
                return $this->redirectToRoute('app_user_new', [], Response::HTTP_SEE_OTHER);
            }

            $userByPhone = $userRepository->findOneBy(['phone' => $form->getData('phone')]);
            if ($userByPhone) {
                $this->addFlash('danger', 'Ce numéro de téléphone est déjà utilisé.');
                return $this->redirectToRoute('app_user_new', [], Response::HTTP_SEE_OTHER);
            }

            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', "Inspecteur ajouté avec succés");
            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'titre' => "Nouveau Inspecteur"
        ]);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
            'titre' => "Détail de l'inspecteur"
        ]);
    }



    #[Route('/{id}/acount', name: 'app_user_acount', methods: ['GET'])]
    public function editAccount(User $user, EntityManagerInterface $entityManager): Response
    {
        $user->setEnabled(!$user->getEnabled());

        $entityManager->persist($user);
        $entityManager->flush();
        $user->getEnabled() == true ?  $this->addFlash('success', "Compte activé avec succés ") :  $this->addFlash('warning', "Compte desactivé avec succés ");

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        UserRepository $userRepository,
        User $user,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $roles = $form->get('roles')->getData();
            $user->setRoles(['ROLE_USER']);
            $user->setAvatar($user->getAvatar());
            $matriculeExite = $userRepository->findBy(['matricule' =>  $form->getData('matricule')]);
            if ($matriculeExite) {
                $this->addFlash('warning', "Ce matricule est déjà utilisé");
                return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', "Mise à jour effectif");

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'titre' => "Mise a jour Information Inspecteur"
        ]);
    }

    #[Route('/{id}', name: 'app_user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
            $this->addFlash('successwarning', "Suppréssion effectif");
        }

        return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
    }
}
