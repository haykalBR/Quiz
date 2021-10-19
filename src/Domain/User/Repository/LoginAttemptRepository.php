<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 19/10/2021
 * Time: 17:54
 */

namespace App\Domain\User\Repository;

use App\Domain\User\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\User\Entity\LoginAttempt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method LoginAttempt|null find($id, $lockMode = null, $lockVersion = null)
 * @method LoginAttempt|null findOneBy(array $criteria, array $orderBy = null)
 * @method LoginAttempt[]    findAll()
 * @method LoginAttempt[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LoginAttemptRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LoginAttempt::class);
    }

    /**
     * Compte le nombre de tentative de connexion pour un utilisateur.
     */
    public function countRecentFor(User $user, int $minutes): int
    {
        return $this->createQueryBuilder('l')
            ->select('COUNT(l.id) as count')
            ->where('l.user = :user')
            ->andWhere('l.createdAt > :date')
            ->setParameter('date', new \DateTime("-{$minutes} minutes"))
            ->setParameter('user', $user)
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleScalarResult();
    }
}