<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 19/10/2021
 * Time: 17:57
 */
namespace App\Domain\User\Security;

use App\Domain\User\Entity\User;
use App\Domain\User\Service\LoginAttemptService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Exception\AccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    /**
     * @var LoginAttemptService
     */
    private LoginAttemptService $attemptService;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;
    public function __construct(LoginAttemptService $attemptService, EntityManagerInterface $manager)
    {
        $this->attemptService = $attemptService;
        $this->manager = $manager;
    }

    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof User) {
            return;
        }
        if (!$user->getEnabled()) {
            throw new UserBannedException();
        }
        if ($this->attemptService->limitReachedFor($user)) {
            $user->setEnabled(false);
            $this->manager->flush();
            throw new TooManyBadCredentialsException();
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
        if (!$user instanceof  User) {
            return;
        }
    }
}