<?php

namespace App\Events;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

//class appelée dans services.yaml, permet d'enrichir les données du token
class JwtCreatedSubscriber
{
    public function updateJwtData(JWTCreatedEvent $event)
    {
        //récupérer l'utilisateur
        $user = $event->getUser();
        //enrichir les datas
        $data = $event->getData();
        $data['firstname'] = $user->getFirstName();
        $data['lastname'] = $user->getLastName();
        $data['id'] = $user->getId();
        $data['picture'] = $user->getProfilPicture();

        //renvoie le tableau enrichi
        $event->setData($data);
//        dd($event->getData());
    }
}