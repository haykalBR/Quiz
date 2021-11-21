<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Entity\Roles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
/**
 * @method Roles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Roles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Roles[]    findAll()
 * @method Roles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RolesRepository  extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Roles::class);
    }
    public function getRolesWithoutAdmin()
    {
        return $this
            ->createQueryBuilder('r')
            ->Where('r.guardName != :guardName')
            ->setParameter('guardName', Roles::ROLE_SUPER_ADMIN);
    }
    public function getSuperAdmin(){
        return $this->createQueryBuilder('r')
            ->select('r')->where('r.guardName like :guardName')
            ->setParameter('guardName','%ROLE_SUPER_ADMIN%' )
            ->getQuery()
            ->getSingleResult();
    }
}