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

class TeamFirstUserAdminSubscriber implements EventSubscriberInterface

{
    private $security;
    private $repository;
    private $repositoryT;
    private $manager;

    public function __construct(Security $security, RoleUserTeamRepository $repository, TeamRepository $repositoryT, EntityManagerInterface $manager)
    {
        $this->security = $security;
        $this->repository = $repository;
        $this->repositoryT = $repositoryT;
        $this->manager = $manager;
    }

    public static function getSubscribedEvents()
    {
        return[
            KernelEvents::VIEW => ['setInstanceUserTeam', EventPriorities::POST_WRITE],
        ];
    }

    public function setInstanceUserTeam(ViewEvent $event)
    {
        $team = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if($team instanceof Team && $method === 'POST')
        {
            //récupère l'utilisateur actuellement connecté
            $user = $this->security->getUser();

            //récupère la dernière team créé
            $lastTeam = $this->repositoryT->findLastTeamCreated();

            //récupère le role admin
            $admin = $this->repository->findOneByRoleAdmin('Admin');

            //cree une instance de l'entité UserTeam et attribue le role admin pour l'utilisateur créateur connecté
            $userTeam = new UserTeam();
            $userTeam->setUser($user);
            $userTeam->setTeam($lastTeam);
            $userTeam->setRoleUserTeam($admin);

            $manager = $this->manager;
            $manager->persist($userTeam);
            $manager->flush();


        }

    }
}