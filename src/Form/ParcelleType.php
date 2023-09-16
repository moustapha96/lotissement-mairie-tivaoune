<?php

namespace App\Form;

use App\Entity\Dimension;
use App\Entity\Lotissement;
use App\Entity\Parcelle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParcelleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('numero', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Numéro',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('lotissement', EntityType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Lotissement',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'class' => Lotissement::class, // Remplacez par la classe de votre entité Lotissement
                'choice_label' => 'denomination', // Remplacez par le champ de l'entité Lotissement que vous souhaitez afficher
            ])
            ->add('dimension', EntityType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Dimension',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'class' => Dimension::class, // Remplacez par la classe de votre entité Dimension
                'choice_label' => 'superficie', // Remplacez par le champ de l'entité Dimension que vous souhaitez afficher
            ])->add('valider', SubmitType::class, [
                'label' => '<i class="fa fa-save"></i> Valider', // Utilisez l'icône de Font Awesome ici
                'label_html' => true, // Permettre l'utilisation de HTML dans le label
                'attr' => ['class' => 'btn btn-outline-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Parcelle::class,
        ]);
    }
}
