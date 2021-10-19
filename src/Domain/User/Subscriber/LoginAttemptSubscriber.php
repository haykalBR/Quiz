<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 19/10/2021
 * Time: 18:02
 */
namespace App\Domain\User\Subscriber;

use App\Domain\User\Event\BadPasswordLoginEvent;
use App\Domain\User\Service\LoginAttemptService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LoginAttemptSubscriber implements EventSubscriberInterface
{
    /**
     * @var LoginAttemptService
     */
    private $loginAttemptService;

    public function __construct(LoginAttemptService $loginAttemptService)
    {
        $this->loginAttemptService = $loginAttemptService;
    }

    /**
     * @return array<string, string>
     */
    public static function getSubscribedEvents(): array
    {
        return [
            BadPasswordLoginEvent::class => 'onAuthenticationFailure',
        ];
    }

    public function onAuthenticationFailure(BadPasswordLoginEvent $event): void
    {
        $this->loginAttemptService->addAttempt($event->getUser());
    }
}