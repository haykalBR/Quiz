<?php

namespace App\Domain\User\Repository;

use App\Core\Repository\BaseRepositoryTrait;

use App\Domain\User\Entity\RefLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(ManagerRegistry $registry,RequestStack $requestStack,UrlGeneratorInterface $urlGenerator)
    {
        parent::__construct($registry, RefLevel::class);
        $this->requestStack = $requestStack;
        $this->urlGenerator = $urlGenerator;
    }
}
