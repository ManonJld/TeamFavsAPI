<?php


namespace App\Controller;

use App\Entity\UserTeam;

class UserGetTeamsController
{
    public function __invoke(UserTeam $data)
    {
        dd($data);

    }
}