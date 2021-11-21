<?php

namespace App\Domain\User\Subscriber;

use App\Domain\User\Event\UpdateGroupEvent;
use App\Domain\User\Service\UserService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserGroupSubscriber implements EventSubscriberInterface
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public static function getSubscribedEvents(): array
    {
        return [
            UpdateGroupEvent::class  => 'updateGroupe'
        ];
    }
    public function updateGroupe(UpdateGroupEvent $event){
       // $this->userService->deleteRolesFromUser($event->getUser());
    }
}