<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class TeamFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $team1 = new Team();
        $team1->setName("dcdev5");
        $team1->setUser($this->getReference("user-marie"));
        $manager->persist($team1);
        $this->addReference("team-dcdev5", $team1);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
