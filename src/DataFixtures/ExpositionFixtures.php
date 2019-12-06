<?php

namespace App\DataFixtures;

use App\Entity\Exposition;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class ExpositionFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // instancier faker
        $faker = Faker::create('fr_FR');

        for($i = 0; $i < 20; $i++){
            $expo = new Exposition();
            $expo
                ->setDescription($faker->text)
                ->setName($faker->unique()->sentence(5))
                ->setDate($faker->dateTimeBetween('-3 years', '5 years', 'Europe/Paris'))
            ;

            // persist : créer un enregistrement
            $manager->persist($expo);
        }
        $manager->flush();
    }
}
