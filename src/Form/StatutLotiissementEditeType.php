<?php

namespace App\Form;

use App\Entity\StatutLotissement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StatutLotiissementEditeType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('statut', EntityType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'class' => StatutLotissement::class,
                'choice_label' => 'denomination',
                'label' => 'Statut',
                'placeholder' => 'Sélectionnez un statut',
                'data' => $this->entityManager->getRepository(StatutLotissement::class)->findOneBy(['denomination' => 'RECEPTION']), // Définit le statut par défaut

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // 'data_class' => StatutLotissement::class,
        ]);
    }
}
