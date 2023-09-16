<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder

            ->add('email', EmailType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Email',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Prénom',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Nom',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Adresse',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('tel', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Téléphone',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Date de Naissance',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('sexe', ChoiceType::class, [
                'choices' => [
                    'Masculin' => 'Masculin',
                    'Féminin' => 'Féminin',
                ],
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Sexe',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])

            ->add('lieuNaissance', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Lieu de Naissance',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER',
                ],
                'multiple' => true,
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Rôles',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('password', PasswordType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Mot de passe',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('isVerified', CheckboxType::class, [
                'required' => false,
                'attr' => ['class' => 'col-6 mx-auto form-check-input'],
                'label' => 'Compte vérifié',
                'label_attr' => ['class' => 'col-6 mx-auto form-check-label'], // Style pour le libellé
            ])
            ->add('valider', SubmitType::class, [
                'label' => '<i class="fa fa-save"></i> Valider', // Utilisez l'icône de Font Awesome ici
                'label_html' => true, // Permettre l'utilisation de HTML dans le label
                'attr' => ['class' => 'btn btn-outline-success col-6 mx-auto'], // Style pour le bouton
            ]);

        // $builder

        //     ->add('email')
        //     ->add('prenom')
        //     ->add('nom')
        //     ->add('adresse')
        //     ->add('tel')
        //     ->add('dateNaissance')
        //     ->add('sexe')
        //     ->add('avatar')
        //     ->add('lieuNaissance')
        //     ->add('roles')
        //     ->add('password')
        //     ->add('isVerified')
        //     ->add('valider', SubmitType::class, [
        //         'label' => '<i class="fa fa-save"></i> Valider', // Utilisez l'icône de Font Awesome ici
        //         'label_html' => true, // Permettre l'utilisation de HTML dans le label
        //         'attr' => ['class' => 'btn btn-outline-success']
        //     ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
