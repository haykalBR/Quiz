<?php

namespace App\Domain\User\Event;

use App\Domain\User\Entity\User;

class MailRegeneratePasswordEvent
{
    private User $user;

    private string $psssword;

    /**
     * MailUserEvent constructor.
     * @param User $user
     * @param string $psssword
     */
    public function __construct(User $user, string $psssword)
    {
        $this->user     = $user;
        $this->psssword = $psssword;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->psssword;
    }
}