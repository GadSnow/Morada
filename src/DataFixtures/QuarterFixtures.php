<?php

namespace App\DataFixtures;

use App\Entity\Quarter;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class QuarterFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $quarter = new Quarter();
            $quarter->setQuarterName($faker->words(3, true));
            $quarter->setCity($this->getReference("city$i"));
            $this->addReference("quarter$i", $quarter);
            $manager->persist($quarter);
        }
        $manager->flush();
        // $product = new Product();
        // $manager->persist($product);

    }
}
