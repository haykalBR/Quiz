<?php
namespace App\Domain\User\Subscriber;
use App\Domain\User\Entity\User;
use App\Domain\User\Service\UserPermissionsService;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\ORM\Events;

class UserPermissionsSubscriber implements EventSubscriber
{
    private RequestStack $requestStack;
    private UserPermissionsService $userPermissionsService;
    public function __construct(RequestStack $requestStack,UserPermissionsService $userPermissionsService)
    {
        $this->requestStack = $requestStack;
        $this->userPermissionsService = $userPermissionsService;
    }

    public function getSubscribedEvents(): array
    {
        return [
               Events::postPersist,
               Events::postUpdate,
        ];
    }
    public function postPersist(LifecycleEventArgs $args){
        /**
         * TODO add condtion from any action Important !!!
         */
        if ($args->getObject() instanceof User){
            $request=$this->requestStack->getCurrentRequest();
            $this->userPermissionsService->CreateUserPermissions($args->getObject(),$request->request->all()['user']);
        }
    }
    public function postUpdate(LifecycleEventArgs $args){
        if ($args->getObject() instanceof User){
            $request=$this->requestStack->getCurrentRequest();
            $this->userPermissionsService->removeUserPermissions($args->getObject());
            $this->userPermissionsService->CreateUserPermissions($args->getObject(),$request->request->all()['user']);
        }
    }

}