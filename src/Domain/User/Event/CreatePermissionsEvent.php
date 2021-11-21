<?php

namespace App\Domain\User\Event;

use Symfony\Component\Security\Core\User\UserInterface;

class CreatePermissionsEvent
{
    private UserInterface $user;
    private array $data;

    public function __construct(UserInterface $user, array $data)
    {
        $this->user     = $user;
        $this->data = $data;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getDate(): array
    {
        return $this->data;
    }

}