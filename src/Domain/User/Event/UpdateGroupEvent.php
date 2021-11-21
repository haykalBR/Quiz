<?php

namespace App\Domain\User\Event;

use Symfony\Component\Security\Core\User\UserInterface;

class UpdateGroupEvent
{
    private UserInterface $user;

    public function __construct(UserInterface $user)
    {
        $this->user     = $user;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

}