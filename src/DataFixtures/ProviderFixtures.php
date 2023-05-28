<?php

namespace App\DataFixtures;

use App\Entity\Provider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ProviderFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $provider = new Provider();
            $provider->setProviderName($faker->name());
            $provider->setProviderEmail($faker->email());
            $provider->setProviderNumber($faker->phoneNumber());
            $this->addReference("provider$i", $provider);

            $manager->persist($provider);
        }
        $manager->flush();
    }
}
