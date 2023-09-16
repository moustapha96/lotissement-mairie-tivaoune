<?php

namespace App\Form;

use App\Entity\Localite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocaliteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Type',
                'label_attr' => ['class' => 'col-6 mx-auto'],
            ])
            ->add('denomination', TextType::class, [
                'attr' => ['class' => 'col-6 mx-auto form-control'],
                'label' => 'Dénomination',
                'label_attr' => ['class' => 'col-6 mx-auto'],
            ])->add('valider', SubmitType::class, [
                'label' => '<i class="fa fa-save"></i> Valider',
                'label_html' => true,
                'attr' => ['class' => 'btn btn-outline-success']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Localite::class,
        ]);
    }
}
