<?php

namespace App\Doctrine;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use App\Entity\Team;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Security;

//Class qui permet de récupérer le user actuellement connecté, et lorsqu'on fera un fetch des Team, seule les teams auxquelles appartient le user s'afficheront
class CurrentUserExtension implements QueryCollectionExtensionInterface
{

    private $security;
    private $auth;

    public function __construct(Security $security, AuthorizationCheckerInterface $checker)
    {
        $this->security = $security;
        $this->auth = $checker;
    }



    public function applyToCollection(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, string $operationName = null)
    {
        //Obtenir l'utilisateur connecté
        $user = $this->security->getUser();
        //A l'appel de Team, agir sur le requête pour qu'elle tienne compte de l'utilisateur connecté, ça vérifie que le user est bien un user de la classe User et que ça n'est pas un ADMIN car lui peut avoir besoin de tout voir
        if($resourceClass === Team::class && !$this->auth->isGranted('ROLE_ADMIN') && $user instanceof User)
        {
            //récupère l'alias de l'entité Team dans la requête qui est o
            $rootAlias = $queryBuilder->getRootAliases()[0];
            $queryBuilder
            ->join($rootAlias . '.userTeams', 'userTeam') //INNER JOIN userTeam ON o.userTeam = userTeam.team_id
            ->join('userTeam.user', 'user') // INNER JOIN user ON userTeam.user = user.userTeam_id
            ->where('user = :user') // WHERE user = $user
            ->setParameter('user', $user);
        }
    }
}