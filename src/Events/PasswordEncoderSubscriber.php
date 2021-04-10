<?php

namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEncoderSubscriber implements EventSubscriberInterface {

    /**
     * @var UserPasswordEncoderInterface
     */
    private UserPasswordEncoderInterface $encoder;

//    cette fonction permet d'appeler et d'utiliser l'encoder de password de symfony
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

//    cette fonction permet de dire qu'avant de persist, il faut utiliser la fonction encodePassword qui est plus bas
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['encodePassword', EventPriorities::PRE_WRITE]
        ];
    }

//    cette fonction permet de hasher le password en utilisant l'encoder appelé plus haut
    public function encodePassword(ViewEvent $event){
//        récupère le résultat de l'event View du kernel
        $newUser = $event->getControllerResult();
        //permet de récupérer la méthode de l'event en cours
        $method = $event->getRequest()->getMethod();

//        permet de vérifier que l'on est bien en train de travailler sur une instance de User en POST pour hasher le password
        if($newUser instanceof User && $method === 'POST'){
            $hash = $this->encoder->encodePassword($newUser, $newUser->getPassword());
            $newUser->setPassword($hash);
//            affiche les données envoyée dans postman
//            dd($newUser);
        }
    }
}
