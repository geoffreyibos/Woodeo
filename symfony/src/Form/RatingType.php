<?php

namespace App\Form;

use App\Entity\Rating;
use Doctrine\Common\Collections\Expr\Value;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('value', NumberType::class, [
            'label' => 'Note',
            'attr' => [
                'min' => 0,
                'max' => 5,
                'step' => 0.5,
            ],
        ])
        ->add('comment',null, [
            'label' => 'Commentaire',
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rating::class,
        ]);
    }
}
