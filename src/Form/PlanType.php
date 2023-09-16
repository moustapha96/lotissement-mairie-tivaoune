<?php

namespace App\Form;

use App\Entity\Lotissement;
use App\Entity\Plan;
use App\Entity\Statut;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\File;

class PlanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'], // Utilisation de Select2 pour le champ "Type"
                'label' => 'Type',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé

            ])
            ->add('statut', ChoiceType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Statut',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'choices' => [
                    'Actif' => true,
                    'Désactivé' => false,
                ],
            ])
            ->add('fichier', FileType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Fichiers',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'multiple' => true, // Permet de sélectionner plusieurs fichiers
                'required' => false, // Facultatif, si les fichiers ne sont pas obligatoires
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf', // Types MIME autorisés pour les fichiers PDF
                        ],
                        'maxSize' => '4096k', // Taille maximale autorisée (4 Mo dans cet exemple)
                        'mimeTypesMessage' => 'Veuillez choisir un fichier PDF.', // Message d'erreur personnalisé
                    ]),
                ],
            ])

            ->add('description', TextareaType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control', 'rows' => 3],
                'label' => 'Description',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('lotissements', EntityType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control select2'], // Utilisation de Select2 pour le champ "Lotissements"
                'label' => 'Lotissements',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'class' => Lotissement::class, // Remplacez par la classe de votre entité Lotissement
                'choice_label' => 'denomination', // Remplacez par le champ de l'entité Lotissement que vous souhaitez afficher
                'multiple' => true, // Permet de sélectionner plusieurs lotissements
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
            // 'data_class' => Plan::class,
        ]);
    }
}