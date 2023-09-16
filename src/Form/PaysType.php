<?php

namespace App\Form;

use App\Entity\Pays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomPays', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Nom du Pays',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('indicatif', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control select2'],
                'label' => 'Indicatif',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé

            ])->add('valider', SubmitType::class, [
                'label' => '<i class="fa fa-save"></i> Valider', // Utilisez l'icône de Font Awesome ici
                'label_html' => true, // Permettre l'utilisation de HTML dans le label
                'attr' => ['class' => 'btn btn-outline-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pays::class,
        ]);
    }
}
