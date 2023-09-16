<?php

namespace App\Form;

use App\Entity\Demandeur;
use App\Entity\Statut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DemandeurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
            ->add('telephone', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Téléphone',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('dateNaissance', DateType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Date de Naissance',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                // Vous pouvez également personnaliser les options pour le champ DateType ici
            ])
            ->add('lieuNaissance', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Lieu de Naissance',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'E-mail',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('nin', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'NIN',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('adresseResidentielle', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Adresse Résidentielle',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])

            ->add('civilite', ChoiceType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Civilité',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'choices' => [
                    'M.' => 'M.',
                    'Mme.' => 'Mme.',
                    'Mlle.' => 'Mlle.',
                ],
                'placeholder' => 'Sélectionnez votre Civilité', // Optionnel : affiche un libellé par défaut
            ])
            ->add('situationMatrimoniale', ChoiceType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Situation Matrimoniale',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'choices' => [
                    'Marié' => 'Marié',
                    'Divorcé' => 'Divorcé',
                    'Veuf' => 'Veuf',
                    'Célibataire' => 'Célibataire',
                ],
            ])


            ->add('nationalite', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Nationalité',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])

            ->add('statut', EntityType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'class' => Statut::class,
                'choice_label' => 'denomination', // Remplacez par le champ de l'entité College que vous souhaitez afficher
                'label' => 'Staut Compte',
                'placeholder' => 'Sélectionnez un statut',
            ])->add('valider', SubmitType::class, [
                'label' => '<i class="fa fa-save"></i> Valider', // Utilisez l'icône de Font Awesome ici
                'label_html' => true, // Permettre l'utilisation de HTML dans le label
                'attr' => ['class' => 'btn btn-outline-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demandeur::class,
        ]);
    }
}
