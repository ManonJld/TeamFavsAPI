<?php

namespace App\DataFixtures;

use App\Entity\UserTeam;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserTeamFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $userTeam1 = new UserTeam();
        $userTeam1->setTeam($this->getReference("team-dcdev5"));
        $userTeam1->setUser($this->getReference("user-marie"));
        $userTeam1->setRoleUserTeam($this->getReference("role-admin"));
        $manager->persist($userTeam1);

        $userTeam2 = new UserTeam();
        $userTeam2->setTeam($this->getReference("team-dcdev5"));
        $userTeam2->setUser($this->getReference("user-pierre"));
        $userTeam2->setRoleUserTeam($this->getReference("role-user"));
        $manager->persist($userTeam2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            TeamFixtures::class,
            RoleUserTeamFixtures::class
        ];
    }
}
