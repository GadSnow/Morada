<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Housing;
use App\Entity\Provider;
use App\Entity\Quarter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HousingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('housingDescription')
            ->add('numberOfRooms')
            ->add('price')
            ->add('sold')
            ->add('bedrooms')
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'clientName'
            ])
            ->add('provider', EntityType::class, [
                'class' => Provider::class,
                'choice_label' => 'providerName'
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'categoryName'
            ])
            ->add('quarter', EntityType::class, [
                'class' => Quarter::class,
                'choice_label' => 'quarterName'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Housing::class,
            'translation_domain' => 'housing'
        ]);
    }
}
