<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ProviderFixtures::class,
            CategoryFixtures::class,
            RegionFixtures::class,
            CityFixtures::class,
            QuarterFixtures::class,
            ProviderFixtures::class,
            ClientFixtures::class,
            HousingFixtures::class
        ];
    }
}
