<?php

namespace App\Form;

use App\Entity\StatutLotissement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatutLotissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('denomination', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Dénomination',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('status', CheckboxType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-check-input'],
                'label' => 'Statut',
                'label_attr' => ['class' => 'col-6 mx-auto '],
                'required' => false,
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
            'data_class' => StatutLotissement::class,
        ]);
    }
}
