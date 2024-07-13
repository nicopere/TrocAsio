<?php

namespace App\Form;

use App\Entity\Calculator;
use App\Enum\CalculatorStatus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculatorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('model', TextType::class)
            ->add('note', TextType::class, [
                'required' => false,
            ])
            ->add('status', EnumType::class, [
                'class' => CalculatorStatus::class,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Calculator::class,
        ]);
    }
}
