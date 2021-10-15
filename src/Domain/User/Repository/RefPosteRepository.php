<?php

namespace App\Domain\User\Repository;

use App\Entity\RefPoste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RefPoste|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefPoste|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefPoste[]    findAll()
 * @method RefPoste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefPosteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefPoste::class);
    }

    // /**
    //  * @return RefPoste[] Returns an array of RefPoste objects
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
    public function findOneBySomeField($value): ?RefPoste
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
