<?php

namespace App\Repository;

use App\Core\Repository\BaseRepositoryTrait;
use App\Entity\RefLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @method RefLevel|null find($id, $lockMode = null, $lockVersion = null)
 * @method RefLevel|null findOneBy(array $criteria, array $orderBy = null)
 * @method RefLevel[]    findAll()
 * @method RefLevel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RefLevelRepository extends ServiceEntityRepository
{
    use BaseRepositoryTrait;
    private RequestStack $requestStack;
    public function __construct(ManagerRegistry $registry,RequestStack $requestStack)
    {
        parent::__construct($registry, RefLevel::class);
        $this->requestStack = $requestStack;
    }
}
