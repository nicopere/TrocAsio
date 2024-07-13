<?php

namespace App\Form;

use App\Entity\Calculator;
use App\Entity\MaintenanceOperation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaintenanceOperationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
            ])
            ->add('action', TextType::class)
            ->add('calculator', EntityType::class, [
                'class' => Calculator::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MaintenanceOperation::class,
        ]);
    }
}
