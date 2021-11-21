<?php

namespace App\Domain\User\Service;

use App\Domain\User\Entity\User;
use App\Domain\User\Repository\RolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
class UserService
{
    private EntityManagerInterface $manager;
    private RolesRepository $rolesRepository;
    public function __construct(EntityManagerInterface $manager,RolesRepository $rolesRepository)
    {
        $this->manager = $manager;
        $this->rolesRepository = $rolesRepository;
    }
    public function deleteGroupFromUser(User $user){
        if (count($user->getGroupes())>0){
            foreach ($user->getGroupes() as $groupe){
                $user->removeGroupe($groupe);
            }
            $this->manager->flush();
        }
    }
    public function deleteRolesFromUser(User $user){
        if (count($user->getRole())>0){
            foreach ($user->getRole() as $role){
                $user->removeRole($role);
            }
        }
        if (count($user->getUserPermissions())>0){
            foreach ($user->getUserPermissions() as $userPermission){
               $this->manager->remove($userPermission);
            }
        }
        $this->manager->flush();
    }
    public function deleteUserCloneFromUser(User $user){
        $user->setUserClone(null);
        $this->manager->flush();
    }
    /**
     * add Group ,Permission and UserPermission from other user
     * @param User $userCurrent
     * @param User $userClone
     */
   public function addRolesAndPermissionFromUserClone(User $userCurrent , User $userClone){
        if (count($userClone->getGroupes())>0){
            foreach ($userClone->getGroupes() as $groupe){
                $userCurrent->addGroupe($groupe);
            }
        }
        if (count($userClone->getRole())>0){
            foreach ($userClone->getRole() as $role){
                $userCurrent->addRole($role);
            }
        }
        if (count($userClone->getUserPermissions())>0){
            foreach ( $userClone->getUserPermissions() as $userPermission) {
                $userClone->addUserPermission($userPermission);
            }
        }
        $this->manager->flush();
    }
}