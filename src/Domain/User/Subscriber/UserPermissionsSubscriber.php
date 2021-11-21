<?php
namespace App\Domain\User\Subscriber;
use App\Domain\User\Event\CreatePermissionsEvent;
use App\Domain\User\Event\UpdatePermissionsEvent;
use App\Domain\User\Service\UserPermissionsService;
use App\Domain\User\Service\UserService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserPermissionsSubscriber implements EventSubscriberInterface
{
    private UserPermissionsService $userPermissionsService;
    private UserService $userService;

    public function __construct(UserPermissionsService $userPermissionsService,UserService $userService)
    {
        $this->userPermissionsService = $userPermissionsService;
        $this->userService = $userService;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            CreatePermissionsEvent::class  => 'createPermissions',
            UpdatePermissionsEvent::class => 'updatePermissions',
        ];
    }
    public function createPermissions(CreatePermissionsEvent $event){
      $this->userPermissionsService->CreateUserPermissions($event->getUser(),$event->getDate());
    }
    public function updatePermissions(UpdatePermissionsEvent $event){
      $this->userService->deleteGroupFromUser($event->getUser());
      $this->userService->deleteUserCloneFromUser($event->getUser());
      $this->userPermissionsService->removeUserPermissions($event->getUser());
      $this->userPermissionsService->CreateUserPermissions($event->getUser(),$event->getDate());
    }

}