<?php

namespace App\Form;

use App\Entity\AccountingEntry;
use App\Entity\Calculator;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountingEntryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
            ])
            ->add('amount', MoneyType::class)
            ->add('calculator', EntityType::class, [
                'class' => Calculator::class,
                'choice_label' => 'id',
                'required' => false,
            ])
            ->add('receiptNumber', IntegerType::class, [
                'required' => false,
            ])
            ->add('name', TextType::class)
            ->add('furtherInformation', TextType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AccountingEntry::class,
        ]);
    }
}
