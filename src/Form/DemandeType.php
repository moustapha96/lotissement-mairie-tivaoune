<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Demandeur;
use App\Entity\Lotissement;
use App\Entity\Statut;
use App\Entity\StatutLotissement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;


class DemandeType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('numero')
            ->add('dateDemande', DateTimeType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-2'],
                'disabled' => true, // Rend le champ non modifiable
                'widget' => 'single_text', // Affiche la date et l'heure comme un champ de texte simple
                'label' => 'Date et heure de la demande',
            ])
            ->add('demandeur', EntityType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-2'],
                'class' => Demandeur::class,
                'choice_label' => 'nom', // Remplacez par le champ de l'entité College que vous souhaitez afficher
                'label' => 'Demandeur',
                'placeholder' => 'Sélectionnez un demandeur',
            ])
            ->add('lotissement', EntityType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-2'],
                'class' => Lotissement::class,
                'choice_label' => 'denomination', // Remplacez par le champ de l'entité College que vous souhaitez afficher
                'label' => 'Lotissement',
                'placeholder' => 'Sélectionnez un lotissement',
            ])
            ->add('demandeAdresseMaire', FileType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-2 '],
                'required' => false,
                'label' => 'Fichier joint pour demande d\'adresse au Maire',
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf', // Ajoutez le mime type pour les fichiers PDF
                        ],
                        'maxSize' => '4096k',
                        'mimeTypesMessage' => 'Veuillez choisir un fichier PDF.',
                    ]),
                ]
            ])
            ->add('cni', FileType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-2 '],
                'required' => false,
                'label' => 'Fichier de la Carte Nationale d\'Identité (CNI)',
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/pdf', // Ajoutez le mime type pour les fichiers PDF
                        ],
                        'maxSize' => '4096k',
                        'mimeTypesMessage' => 'Veuillez choisir un fichier PDF.',
                    ]),
                ]
            ])



            ->add('statut', EntityType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'class' => StatutLotissement::class,
                'choice_label' => 'denomination',
                'label' => 'Statut',
                'placeholder' => 'Sélectionnez un statut',
                'data' => $this->entityManager->getRepository(StatutLotissement::class)->findOneBy(['denomination' => 'RECEPTION']), // Définit le statut par défaut
                'disabled' => true, // Désactive le champ
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
            'data_class' => Demande::class,
        ]);
    }
}
