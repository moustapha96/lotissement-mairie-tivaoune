<?php

namespace App\Form;

use App\Entity\ModelSms;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ModelSmsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // $builder
        //     ->add('code', TextType::class, [
        //         'attr' => ['class' => 'col-6 mx-auto form-control'],
        //         'label' => 'Code',
        //         'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
        //     ])
        //     ->add('message', TextType::class, [
        //         'attr' => ['class' => 'col-6 mx-auto form-control'],
        //         'label' => 'Message',
        //         'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
        //     ])
        //     ->add('parametre', TextType::class, [
        //         'attr' => ['class' => 'col-6 mx-auto form-control'],
        //         'label' => 'Parametre',
        //         'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
        //     ])
        //     ->add('valider', SubmitType::class, [
        //         'label' => '<i class="fa fa-save"></i> Valider', // Utilisez l'icône de Font Awesome ici
        //         'label_html' => true, // Permettre l'utilisation de HTML dans le label
        //         'attr' => ['class' => 'btn btn-outline-success']
        //     ]);



        $builder
            ->add('code', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Code',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('message', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Message',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('parametre', CollectionType::class, [
                'entry_type' => TextType::class, // Le type de champ à l'intérieur de la collection
                'entry_options' => [
                    'attr' => ['class' => 'col-6 mx-auto form-control'], // Attributs pour chaque champ de la collection
                ],
                'label' => 'Parametre',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'allow_add' => true, // Permettre l'ajout dynamique de champs
                'allow_delete' => true, // Permettre la suppression dynamique de champs
                'prototype' => true, // Activer le prototype JavaScript
                'attr' => [
                    'class' => 'col-6 mx-auto form-control', // Attributs pour le champ de la collection
                    'data-prototype' => '__name__label__ __name__widget__', // Prototype HTML pour JavaScript
                ],
            ])
            ->add('valider', SubmitType::class, [
                'label' => '<i class="fa fa-save"></i> Valider', // Utilisez l'icône de Font Awesome ici
                'label_html' => true, // Permettre l'utilisation de HTML dans le label
                'attr' => ['class' => 'btn btn-outline-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ModelSms::class,
        ]);
    }
}
