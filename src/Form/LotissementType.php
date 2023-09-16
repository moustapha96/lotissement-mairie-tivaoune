<?php

namespace App\Form;

use App\Entity\Localite;
use App\Entity\Lotissement;
use App\Entity\Plan;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LotissementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('denomination', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Dénomination',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Adresse',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('numero', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Numéro',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('plans', EntityType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Plans',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'class' => Plan::class, // Remplacez par la classe de votre entité Plan
                'choice_label' => 'type', // Remplacez par le champ de l'entité Plan que vous souhaitez afficher
                'multiple' => true, // Autorisez la sélection de plusieurs plans
                'expanded' => true, // Facultatif : affichez les options sous forme de cases à cocher
            ])
            ->add('localite', EntityType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Localité',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'class' => Localite::class, // Remplacez par la classe de votre entité Localite
                'choice_label' => 'denomination', // Remplacez par le champ de l'entité Localite que vous souhaitez afficher
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
            'data_class' => Lotissement::class,
        ]);
    }
}
