<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('first_name', TextType::class, ['label' => 'Имя'])
            ->add('middle_name', TextType::class, ['label' => 'Отчество'])
            ->add('last_name', TextType::class, ['label' => 'Фамилия'])
            ->add('age', IntegerType::class, ['label' => 'Возраст'])
            ->add('phone', TextType::class, ['label' => 'Телефон'])
            ->add('guardian_name', TextType::class, ['label' => 'Имя опекуна'])
            ->add('guardian_phone', TextType::class, ['label' => 'Телефон опекуна'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
