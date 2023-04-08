<?php

namespace App\DataFixtures;

use App\Entity\City;
use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CityFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $region = new Region();

        for ($i = 0; $i < 5; $i++) {
            $city = new City();
            $city
            ->setCityName($faker->words(3, true))
            ->setRegion($region->get);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
