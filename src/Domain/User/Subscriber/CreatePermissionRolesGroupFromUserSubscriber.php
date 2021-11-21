<?php

namespace App\Domain\User\Subscriber;

use App\Domain\User\Event\CreatePermissionRolesGroupFromUserEvent;
use App\Domain\User\Service\UserService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CreatePermissionRolesGroupFromUserSubscriber implements EventSubscriberInterface
{
    private UserService $userService;
    public function __construct(UserService $userService )
    {
        $this->userService = $userService;
    }


    public function addRolesAndPermissionFromUserClone(CreatePermissionRolesGroupFromUserEvent $event){
        $this->userService->deleteGroupFromUser($event->getCurentUser());
        $this->userService->deleteRolesFromUser($event->getCurentUser());
        $this->userService->addRolesAndPermissionFromUserClone($event->getCurentUser(),$event->getCloneUser());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CreatePermissionRolesGroupFromUserEvent::class => 'addRolesAndPermissionFromUserClone',
        ];
    }
}