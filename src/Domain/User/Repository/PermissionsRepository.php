<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Entity\Permissions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Permissions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Permissions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Permissions[]    findAll()
 * @method Permissions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PermissionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Permissions::class);
    }
    /**
     * get all name of guard
     */
    public function findGuardName(){
        return $this->createQueryBuilder('p')
            ->select('p.guardName')
            ->getQuery()
            ->getArrayResult();
    }
}
