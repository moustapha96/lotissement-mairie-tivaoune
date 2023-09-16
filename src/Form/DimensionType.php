<?php

namespace App\Form;

use App\Entity\Dimension;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DimensionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('longueur', ChoiceType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Longueur',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'choices' => [
                    '1 mètre' => '1',
                    '2 mètres' => '2',
                    '3 mètres' => '3',
                    '4 mètres' =>
                    '4',
                    '5 mètres' =>
                    '5',
                    '6 mètres' => '6',
                    // Ajoutez d'autres valeurs de longueur au besoin
                ],
            ])
            ->add('largeur', ChoiceType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Largeur',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'choices' => [
                    '1 mètre' => '1',
                    '2 mètres' => '2',
                    '3 mètres' => '3',
                    // Ajoutez d'autres valeurs de largeur au besoin
                ],
            ])
            ->add('superficie', ChoiceType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Superficie',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'choices' => [
                    '10 mètres carrés' => '10',
                    '20 mètres carrés' => '20',
                    '30 mètres carrés' => '30',
                    '40 mètres carrés' => '40',
                    // Ajoutez d'autres valeurs de superficie au besoin
                ],
            ])->add('valider', SubmitType::class, [
                'label' => '<i class="fa fa-save"></i> Valider', // Utilisez l'icône de Font Awesome ici
                'label_html' => true, // Permettre l'utilisation de HTML dans le label
                'attr' => ['class' => 'btn btn-outline-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Dimension::class,
        ]);
    }
}
