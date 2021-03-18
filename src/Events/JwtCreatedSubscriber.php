<?php

namespace App\Events;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;

//class non utilisée. Si je veux l'utiliser, décommenter les lignes dans services.yaml
class JwtCreatedSubscriber
{
    public function updateJwtData(JWTCreatedEvent $event)
    {

        dd($event->getData());
    }
}