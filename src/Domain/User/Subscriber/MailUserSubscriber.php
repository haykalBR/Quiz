<?php

namespace App\Domain\User\Subscriber;

use App\Domain\User\Event\MailAddUserEvent;
use App\Domain\User\Event\MailRegeneratePasswordEvent;
use App\Domain\User\Service\MailerUserService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MailUserSubscriber implements EventSubscriberInterface
{
    private MailerUserService $mailerUserService;

    public function __construct(MailerUserService $mailerUserService)
    {
        $this->mailerUserService = $mailerUserService;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents(): array
    {
        return [
            MailAddUserEvent::class            => 'sendAddUser',
            MailRegeneratePasswordEvent::class => 'regeneratePassword',
        ];
    }

    public function sendAddUser(MailAddUserEvent $event): void
    {
        $this->mailerUserService->sendAddUser($event->getUser(), $event->getPassword());
    }

    public function regeneratePassword(MailRegeneratePasswordEvent $event)
    {
        $this->mailerUserService->changePasswordUser($event->getUser(), $event->getPassword());
    }
}