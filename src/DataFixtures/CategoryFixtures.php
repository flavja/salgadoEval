<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $list = ['Dessin', 'Peinture', 'Sculpture'];

        for($i = 0; $i<count($list); $i++){
            $categorie = new Category();
            $categorie->setName($list[$i]);
            $this->addReference("categorie$i", $categorie);
            $manager->persist($categorie);
        }

        $manager->flush();
    }
}
