<?php

namespace App\Form;

use App\Entity\Demande;
use App\Entity\Demandeur;
use App\Entity\Lotissement;
use App\Entity\Pays;
use App\Entity\StatutLotissement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

use Symfony\Component\Validator\Constraints as Assert;


class DemandeFormType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
                'label_attr' => ['class' => 'col-6 mx-auto'],
                'label' => 'Prénom',
            ])
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
                'label' => 'Nom',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
                'label' => 'Adresse',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])

            ->add('telephone', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
                'label' => 'Téléphone',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'constraints' => [
                    new Regex([
                        'pattern' => '/^(77|78|70|75|76)[0-9]{7}$/',
                        'message' => 'Le numéro de téléphone n\'est pas valide. Il doit commencer par l\'une des séquences : 76, 77, 78, 70 ou 75, suivie de 7 chiffres.',
                    ]),
                ],
            ])

            ->add('dateNaissance', DateType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
                'label' => 'Date de Naissance',
                'label_attr' => ['class' => 'col-6 mx-auto'],
                'widget' => 'single_text',
                // 'html5' => true,
                // 'format' => 'dd/MM/yyyy',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\LessThan('-18 years'),
                    new Assert\GreaterThanOrEqual('1900-01-01'),

                ],
            ])
            ->add('lieuNaissance', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3 '],
                'label' => 'Lieu de Naissance',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
                'label' => 'E-mail',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])
            ->add('nin', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
                'label' => 'NIN',
                'label_attr' => ['class' => 'col-6 mx-auto'],
                'constraints' => [
                    new Length([
                        'min' => 13,
                        'max' => 13,
                        'exactMessage' => 'Le NIN doit contenir exactement {{ limit }} chiffres.',
                    ]),
                ], // Style pour le libellé
            ])
            ->add('adresseResidentielle', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
                'label' => 'Adresse Résidentielle',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
            ])

            ->add('civilite', ChoiceType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
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
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
                'label' => 'Situation Matrimoniale',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'choices' => [
                    'Marié' => 'Marié',
                    'Divorcé' => 'Divorcé',
                    'Veuf' => 'Veuf',
                    'Célibataire' => 'Célibataire',
                ],
            ])


            ->add('nationalite', ChoiceType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
                'label' => 'Nationalité',
                'label_attr' => ['class' => 'col-6 mx-auto'], // Style pour le libellé
                'choices' => $this->getNationaliteChoices(), // Utilisez une méthode pour obtenir les choix
                'choice_label' => function ($value, $key, $index) {
                    return $key;
                },
                'choice_value' => function ($key) {
                    return $key;
                },
            ])

            ->add('demandeAdresseMaire', FileType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
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
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
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


            ->add('lotissement', EntityType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control m-3'],
                'class' => Lotissement::class,
                'choice_label' => 'denomination', // Remplacez par le champ de l'entité College que vous souhaitez afficher
                'label' => 'Lotissement',
                'placeholder' => 'Sélectionnez un lotissement',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null
        ]);
    }

    private function getNationaliteChoices()
    {
        // Récupérez les pays depuis la base de données (table "Pays")
        $paysRepository = $this->entityManager->getRepository(Pays::class);
        $pays = $paysRepository->findAll();

        // Créez un tableau de choix avec le nom du pays et l'indicatif
        $choices = [];
        foreach ($pays as $pays) {
            $choices[$pays->getNomPays() . ' (' . $pays->getIndicatif() . ')'] = $pays->getNomPays();
        }

        return $choices;
    }
}
