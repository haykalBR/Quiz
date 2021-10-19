<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 19/10/2021
 * Time: 17:53
 */
namespace App\Domain\User\Service;

use App\Domain\User\Entity\LoginAttempt;
use App\Domain\User\Entity\User;
use App\Domain\User\Repository\LoginAttemptRepository;
use Doctrine\ORM\EntityManagerInterface;

class LoginAttemptService
{
    const ATTEMPTS = 3;

    private LoginAttemptRepository $repository;
    private EntityManagerInterface $em;

    public function __construct(
        LoginAttemptRepository $repository,
        EntityManagerInterface $em
    ) {
        $this->repository = $repository;
        $this->em         = $em;
    }

    public function addAttempt(User $user): void
    {
        // TODO : Envoyer un email au bout du Xème essai
        $attempt = (new LoginAttempt())->setUser($user);
        $this->em->persist($attempt);
        $this->em->flush();
    }

    public function limitReachedFor(User $user): bool
    {
        return $this->repository->countRecentFor($user, 30) >= self::ATTEMPTS;
    }

}