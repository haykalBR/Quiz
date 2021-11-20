<?php

namespace App\Domain\User\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserFormSubscriber implements EventSubscriberInterface
{
    const EDIT_ROUTE = 'admin_edit_users';

    private RequestStack $requestStack;
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetData',
        ];
    }
    public function onPreSetData(FormEvent $event){
        $this->showPassword($event);
    }
    private function showPassword(FormEvent $event)
    {
        $form = $event->getForm();
        if (self::EDIT_ROUTE !== $this->requestStack->getCurrentRequest()->get('_route')) {
            $form->add('plainPassword', RepeatedType::class, [
                'type'        => PasswordType::class,
                'mapped'      => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min'        => 10,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max'        => 4096,
                    ]),
                ],
                'first_options'   => ['label' => 'Password'],
                'second_options'  => ['label' => 'Confirm Password'],
                'invalid_message' => 'Your password does not match the confirmation.',
            ]);
        }
    }
}
