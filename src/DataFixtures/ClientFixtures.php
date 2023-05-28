<?php

namespace App\DataFixtures;

use App\Entity\Client;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ClientFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $client = new Client();
            $client->setClientName($faker->name());
            $client->setClientNumber($faker->phoneNumber());
            $client->setClientEmail($faker->email());
            $this->addReference("client$i", $client);
            $manager->persist($client);
        }
        $manager->flush();
        // $product = new Product();
        // $manager->persist($product);

    }
}
