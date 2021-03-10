<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $cate1 = new Category();
        $cate1->setName("Web design");
        $cate1->setTeam($this->getReference("team-dcdev5"));
        $cate1->setUser($this->getReference("user-marie"));
        $cate1->setDescription("Liens en rapport avec le design pour trouver de l'inspiration");
        $manager->persist($cate1);
        $this->addReference("cate-web-design", $cate1);

        $cate2= new Category();
        $cate2->setName("CSS");
        $cate2->setTeam($this->getReference("team-dcdev5"));
        $cate2->setUser($this->getReference("user-marie"));
        $cate2->setDescription("Astuces et apprentissage du css");
        $manager->persist($cate2);
        $this->addReference("cate-css", $cate2);

        $cate3 = new Category();
        $cate3->setName("Symfony");
        $cate3->setTeam($this->getReference("team-dcdev5"));
        $cate3->setUser($this->getReference("user-pierre"));
        $cate3->setDescription("Documentations et astuces pour Symfony");
        $manager->persist($cate3);
        $this->addReference("team-symfony", $cate3);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TeamFixtures::class
        ];
    }
}
