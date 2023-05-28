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

        for ($i = 0; $i < 5; $i++) {
            $city = new City();
            $city->setCityName($faker->city());
            $city->setRegion($this->getReference("region$i"));
            $this->addReference("city$i", $city);
            $manager->persist($city);
        }

        $manager->flush();


        // $product = new Product();
        // $manager->persist($product);

    }
}
