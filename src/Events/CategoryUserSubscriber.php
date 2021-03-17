<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Category;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class CategoryUserSubscriber implements EventSubscriberInterface
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setUserForCategory', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setUserForCategory(ViewEvent $event)
    {
        $category = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if($category instanceof Category && $method === 'POST')
        {
            //récupère l'utilisateur actuellement connecté
            $user = $this->security->getUser();
            //assigne l'utilisateur à la catégorie qu'on est en train de créer
            $category->setUser($user);
        }
    }

}