<?php

namespace App\DataFixtures;

use App\Entity\Bookmark;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BookmarkFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $bookmark1 = new Bookmark();
        $bookmark1->setName("A complete guide to flexbox");
        $bookmark1->setUrl("https://css-tricks.com/snippets/css/a-guide-to-flexbox/");
        $bookmark1->setDescription("Guide clair sur l'utilisation de flexbox avec explication + descriptions visuelle");
        $bookmark1->setUser($this->getReference("user-marie"));
        $bookmark1->setCategory($this->getReference("cate-css"));
        $manager->persist($bookmark1);

        $bookmark2 = new Bookmark();
        $bookmark2->setName("Footer en pied de page");
        $bookmark2->setUrl("https://www.emmanuelbeziat.com/blog/un-site-qui-prend-toute-la-hauteur-disponible#la-methode-moderne-amelioree-ie-10");
        $bookmark2->setDescription("Emmanuel Béziat propose plusieurs solutions techniques très simple pour que le footer reste en bas de page même s'il y a très peu de contenu sur la page");
        $bookmark2->setUser($this->getReference("user-marie"));
        $bookmark2->setCategory($this->getReference("cate-css"));
        $manager->persist($bookmark2);

        $bookmark3 = new Bookmark();
        $bookmark3->setName("CSS gradient");
        $bookmark3->setUrl("https://cssgradient.io/");
        $bookmark3->setDescription("site qui permet de créer des gradients css facilement, aves plein d'options possibles");
        $bookmark3->setUser($this->getReference("user-pierre"));
        $bookmark3->setCategory($this->getReference("cate-css"));
        $manager->persist($bookmark3);


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class
        ];
    }
}
