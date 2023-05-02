<?php

namespace App\Form;

use App\Entity\City;
use App\Entity\Region;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cityName')
            ->add('imageFile', FileType::class, [
                'required' =>  false
            ])
            ->add('region', EntityType::class, [
                'class' => Region::class,
                'choice_label' => 'regionName'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => City::class,
            'translation_domain' => 'city'
        ]);
    }
}
