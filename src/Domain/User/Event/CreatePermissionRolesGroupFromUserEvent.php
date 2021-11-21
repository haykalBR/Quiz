<?php

namespace App\Domain\User\Event;

use App\Domain\User\Entity\User;

class CreatePermissionRolesGroupFromUserEvent
{
    private User $curentUser;
    private User $cloneUser;
    public function __construct(User $curentUser, User $cloneUser)
    {
        $this->curentUser = $curentUser;
        $this->cloneUser = $cloneUser;
    }
    /**
     * @return User
     */
    public function getCurentUser(): User
    {
        return $this->curentUser;
    }
    /**
     * @return User
     */
    public function getCloneUser(): User
    {
        return $this->cloneUser;
    }

}