<?php

namespace App\DataFixtures;

use App\Entity\Housing;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class HousingFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        for ($i = 0; $i < 50; $i++) {
            $housing = new Housing();
            $housing->setHousingDescription($faker->sentence(6, false));
            $housing->setNumberOfRooms($faker->numberBetween(5, 8));
            $housing->setBedrooms($faker->numberBetween(1, 3));
            $housing->setPrice($faker->numberBetween(300000, 5000000));
            $housing->setTitle($faker->words(2, true));
            $housing->setSold($faker->boolean(25));

            $numbers = [1, 2, 3, 4];
            shuffle($numbers);
            $housing->setCategory($this->getReference("category$numbers[0]"));
            $housing->setClient($this->getReference("client$numbers[1]"));
            $housing->setProvider($this->getReference("provider$numbers[2]"));
            $housing->setQuarter($this->getReference("quarter$numbers[3]"));

            $manager->persist($housing);
        }
        $manager->flush();
    }
}
