<?php

namespace App\Repository;

use App\Entity\RefQuestionType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RefQuestionType|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefQuestionType|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefQuestionType[]    findAll()
 * @method RefQuestionType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefQuestionTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RefQuestionType::class);
    }

    // /**
    //  * @return RefQuestionType[] Returns an array of RefQuestionType objects
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
    public function findOneBySomeField($value): ?RefQuestionType
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
