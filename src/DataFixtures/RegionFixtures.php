<?php

namespace App\DataFixtures;

use App\Entity\Region;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RegionFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $region = new Region();
            $region->setRegionName($faker->words(3, true));
            $this->addReference("region$i", $region);
            $manager->persist($region);
        }
        $manager->flush();
        // $product = new Product();
        // $manager->persist($product);

    }
}
