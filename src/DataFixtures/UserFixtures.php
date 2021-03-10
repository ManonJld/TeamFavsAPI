<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $manon = new User();
        $manon->setEmail("manon.jeuland@gmail.com");
        $manon->setFirstName("Manon");
        $manon->setLastName("Jeuland");
        $manon->setRoles(["ROLE_ADMIN"]);
        $password = $this->encoder->encodePassword($manon, "admin");
        $manon->setPassword($password);
        $manager->persist($manon);
        $this->addReference("superadmin-manon", $manon);

        $marie = new User();
        $marie->setEmail("marie.hamsany@gmail.com");
        $marie->setFirstName("Marie");
        $marie->setLastName("Hamsany");
        $password = $this->encoder->encodePassword($marie, "marie");
        $marie->setPassword($password);
        $manager->persist($marie);
        $this->addReference("user-marie", $marie);

        $pierre = new User();
        $pierre->setEmail("pierre.jehan@gmail.com");
        $pierre->setFirstName("Pierre");
        $pierre->setLastName("Jehan");
        $password = $this->encoder->encodePassword($pierre, "pierre");
        $pierre->setPassword($password);
        $manager->persist($pierre);
        $this->addReference("user-pierre", $pierre);

        $manager->flush();
    }
}
