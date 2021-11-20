<?php

namespace App\Domain\Exam\Repository\Domain\Categories\Entity;

use App\Domain\Categories\Entity\TechnologyCategories;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TechnologyCategories|null find($id, $lockMode = null, $lockVersion = null)
 * @method TechnologyCategories|null findOneBy(array $criteria, array $orderBy = null)
 * @method TechnologyCategories[]    findAll()
 * @method TechnologyCategories[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnologyCategoriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TechnologyCategories::class);
    }

    // /**
    //  * @return TechnologyCategories[] Returns an array of TechnologyCategories objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TechnologyCategories
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
