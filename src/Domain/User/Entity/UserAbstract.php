<?php

namespace App\Domain\User\Entity;

abstract class UserAbstract implements \Symfony\Component\Security\Core\User\UserInterface
{
    /**
     * Checks whether a user has a certain permission.
     *
     * @param string $permission
     * The permission string to check
     *
     * @return bool
     *TRUE if the user has the permission, FALSE otherwise
     */
    public abstract function hasPermission(string $permission);
    /**
     * Tells if the the given user has the super admin role.
     *
     * @return bool
     */
    public abstract function isSuperAdmin();
    /**
     * Whether a user has a certain role.
     *
     * @param string $role
     * The role ID to check
     *
     * @return bool
     * Returns TRUE if the user has the role, otherwise FALSE
     */
    public abstract function hasRole(RoleInterface $role);
}