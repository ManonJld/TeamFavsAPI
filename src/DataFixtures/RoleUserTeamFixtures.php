<?php

namespace App\DataFixtures;

use App\Entity\RoleUserTeam;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RoleUserTeamFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $role1 = new RoleUserTeam();
        $role1->setRole("Admin");
        $manager->persist($role1);
        $this->addReference("role-admin", $role1);

        $role2= new RoleUserTeam();
        $role2->setRole("User");
        $manager->persist($role2);
        $this->addReference("role-user", $role2);

        $manager->flush();
    }
}
