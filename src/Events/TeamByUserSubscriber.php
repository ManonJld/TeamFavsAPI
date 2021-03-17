<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Team;
use App\Entity\UserTeam;
use App\Repository\RoleUserTeamRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class TeamByUserSubscriber implements EventSubscriberInterface
{
    private $security;
    private $repository;
    private $repositoryT;

    public function __construct(Security $security, RoleUserTeamRepository $repository, TeamRepository $repositoryT)
    {
        $this->security = $security;
        $this->repository = $repository;
        $this->repositoryT = $repositoryT;
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
        }
    }

//    public function setInstanceUserTeam(ViewEvent $event, EntityManagerInterface $entityManager)
//    {
//        $team = $event->getControllerResult();
//        $method = $event->getRequest()->getMethod();
//
//        if($team instanceof Team && $method === 'POST')
//        {
//            //récupère l'utilisateur actuellement connecté
//            $user = $this->security->getUser();
//
//            //récupère la dernière team créé
//            $lastTeam = $this->repositoryT->findLastTeamCreated();
//
//            //récupère le role admin
//            $admin = $this->repository->findOneByRoleAdmin('Admin');
//
//            //cree une instance de l'entité UserTeam et attribue le role admin pour l'utilisateur créateur connecté
//            $userTeam = new UserTeam();
//            $userTeam->setUser($user);
//            $userTeam->setTeam($lastTeam);
//            $userTeam->setRoleUserTeam($admin);
//            $entityManager->persist($userTeam);
//            $entityManager->flush();
//
//
//        }
//
//    }
}