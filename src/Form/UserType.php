<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Почта',
                'attr'  => ['class' => 'form-control my-2', 'placeholder' => 'Почта'],
            ])
            ->add('password', TextType::class, [
                'label'      => 'Пароль',
                'empty_data' => '',
                'required'   => false,
                'attr'       => ['class' => 'form-control my-2', 'value' => '', 'placeholder' => 'Пароль'],
            ])
//            ->add('weekends', TextType::class, [
//                'label'      => 'Выходные <span class="small text-muted">(Пример: 1,2,7,8,15,16)</span>',
//                'label_html' => true,
//                'required'   => false,
//                'attr'       => ['class' => 'form-control my-2', 'placeholder' => 'Выходные'],
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
