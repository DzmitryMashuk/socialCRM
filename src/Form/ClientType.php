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
            ->add('first_name', TextType::class, [
                'label' => 'Имя',
                'attr'  => ['class' => 'form-control my-2', 'placeholder' => 'Имя'],
            ])
            ->add('middle_name', TextType::class, [
                'label' => 'Отчество',
                'attr'  => ['class' => 'form-control my-2', 'placeholder' => 'Отчество'],
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Фамилия',
                'attr'  => ['class' => 'form-control my-2', 'placeholder' => 'Фамилия'],
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Возраст',
                'attr'  => ['class' => 'form-control my-2', 'placeholder' => 'Возраст'],
            ])
            ->add('phone', TextType::class, [
                'label'    => 'Телефон',
                'required' => false,
                'attr'     => ['class' => 'form-control my-2', 'placeholder' => 'Телефон'],
            ])
            ->add('guardian_name', TextType::class, [
                'label'    => 'Имя опекуна',
                'required' => false,
                'attr'     => ['class' => 'form-control my-2', 'placeholder' => 'Имя опекуна'],
            ])
            ->add('guardian_phone', TextType::class, [
                'label'    => 'Телефон опекуна',
                'required' => false,
                'attr'     => ['class' => 'form-control my-2', 'placeholder' => 'Телефон опекуна'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
