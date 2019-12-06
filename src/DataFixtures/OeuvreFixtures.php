<?php

namespace App\DataFixtures;

use App\Entity\Oeuvre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory as Faker;

class OeuvreFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // instancier faker
        $faker = Faker::create('fr_FR');

        // pour remplir la table, créer des objets puis les persister
        for($i = 0; $i < 20; $i++){
            $oeuvre = new Oeuvre();
            $oeuvre
                ->setDescription($faker->text)
                ->setImage($faker->imageUrl(800, 450))
                ->setName($faker->unique()->sentence(3))
            ;

            // récupération d'une référence créée dans CategoryFixtures
            $randomCategory = random_int(0, 2);
            $oeuvre->setCategory( $this->getReference("categorie$randomCategory") );

            // persist : créer un enregistrement
            $manager->persist($oeuvre);
        }
        $manager->flush();
    }
}
