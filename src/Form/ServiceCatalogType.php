<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\ServiceCatalog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceCatalogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Название',
                'attr'  => ['class' => 'form-control my-2', 'placeholder' => 'Название']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServiceCatalog::class,
        ]);
    }
}
