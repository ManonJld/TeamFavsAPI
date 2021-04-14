<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Team;
use App\Entity\UserTeam;
use App\Repository\RoleUserTeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class TeamUserSubscriber implements EventSubscriberInterface
{
    private $security;
    private $repository;
    private $entityManager;

    public function __construct(Security $security, RoleUserTeamRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return[
            KernelEvents::VIEW => ['setUserForTeam', EventPriorities::PRE_VALIDATE],
        ];
    }

    public function setUserForTeam(ViewEvent $event)
    {
        $team = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if($team instanceof Team && $method === 'POST')
        {
            //récupère l'utilisateur actuellement connecté
            $user = $this->security->getUser();
            //assigne l'utilisateur à la catégorie qu'on est en train de créer
            $team->setUser($user);

            //récupère le role admin
            $admin = $this->repository->findOneByRoleAdmin('Admin');

            //cree une instance de l'entité UserTeam et attribue le role admin pour l'utilisateur créateur connecté
            //Il faut qu'il y ait un cascade persist + quelques infos dans mes 2 entité concernées pour que ça fonctionne
            $userTeam = new UserTeam();
            $userTeam->setUser($user);
            $userTeam->setTeam($team);
            $userTeam->setRoleUserTeam($admin);
            $manager = $this->entityManager;
            $manager->persist($userTeam);
            $manager->flush();
        }


    }
}