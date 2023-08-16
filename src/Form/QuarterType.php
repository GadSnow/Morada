<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Quarter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuarterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quarterName')
            ->add('city', EntityType::class, [
                'class' => City::class,
                'choice_label' => 'cityName'
            ])
            ->add('imageFile', FileType::class, [
                'required' =>  false
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quarter::class,
            'translation_domain' => 'quarter'
        ]);
    }
}
