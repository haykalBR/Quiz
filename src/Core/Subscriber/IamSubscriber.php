<?php

namespace App\Core\Subscriber;

use App\Core\Services\IamService;
use App\Domain\User\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Security;

class IamSubscriber implements EventSubscriberInterface
{
    private Security  $security;
    private RequestStack $requestStack;
    private IamService $iamService;
    public function __construct(Security $security,RequestStack $requestStack,IamService $iamService)
    {
        $this->security = $security;
        $this->requestStack = $requestStack;
        $this->iamService = $iamService;
    }
    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
    public function onKernelRequest(RequestEvent $event)
    {
        $currentRoute=$this->requestStack->getCurrentRequest()->get('_route');
        if($this->iamService->getAnonymousRoutes($currentRoute))
            return true;
        /**
         * @var $currentUser User
         */
        $currentUser = $this->security->getUser();
        if (!$currentUser)
            return true;
        if ($currentUser->isSuperAdmin())
            return true;
        if ($currentUser->hasPermission($currentRoute))
            return true;

        throw new AccessDeniedHttpException("Permission Denied ");

    }


}