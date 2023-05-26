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
                'attr'  => ['class' => 'form-control my-2', 'placeholder' => 'Имя', 'maxlength' => 255],
            ])
            ->add('middle_name', TextType::class, [
                'label' => 'Отчество',
                'attr'  => ['class' => 'form-control my-2', 'placeholder' => 'Отчество', 'maxlength' => 255],
            ])
            ->add('last_name', TextType::class, [
                'label' => 'Фамилия',
                'attr'  => ['class' => 'form-control my-2', 'placeholder' => 'Фамилия', 'maxlength' => 255],
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Возраст',
                'attr'  => ['class' => 'form-control my-2', 'placeholder' => 'Возраст'],
            ])
            ->add('phone', TextType::class, [
                'label'    => 'Телефон',
                'required' => false,
                'attr'     => ['class' => 'form-control my-2', 'placeholder' => 'Телефон', 'maxlength' => 25],
            ])
            ->add('guardian_name', TextType::class, [
                'label'    => 'Имя опекуна',
                'required' => false,
                'attr'     => ['class' => 'form-control my-2', 'placeholder' => 'Имя опекуна', 'maxlength' => 255],
            ])
            ->add('guardian_phone', TextType::class, [
                'label'    => 'Телефон опекуна',
                'required' => false,
                'attr'     => ['class' => 'form-control my-2', 'placeholder' => 'Телефон опекуна', 'maxlength' => 25],
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
