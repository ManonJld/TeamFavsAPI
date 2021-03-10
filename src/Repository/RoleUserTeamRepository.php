<?php

namespace App\Repository;

use App\Entity\RoleUserTeam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RoleUserTeam|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoleUserTeam|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoleUserTeam[]    findAll()
 * @method RoleUserTeam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleUserTeamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoleUserTeam::class);
    }

    // /**
    //  * @return RoleUserTeam[] Returns an array of RoleUserTeam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RoleUserTeam
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
