<?php

namespace App\Domain\User\Service;

use App\Domain\User\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Twig\Environment;

class MailerUserService
{
    private MailerInterface $mailer;

    private RouterInterface $router;

    private Environment $environment;

    public function __construct(MailerInterface $mailer, RouterInterface $router, Environment $environment)
    {
        $this->mailer      = $mailer;
        $this->router      = $router;
        $this->environment = $environment;
    }

    /**
     *  Send Email with detailes for user after added.
     *
     * @return Response
     */
    public function sendAddUser(User $user, string $password): void
    {
        try {
            $url   = $this->router->generate('admin_app_login', [], UrlGeneratorInterface::ABSOLUTE_URL);
            $email = (new TemplatedEmail())
                ->from('haikelbrinis@gmail.com')
                ->to($user->getEmail())
                ->subject('Time for Symfony Mailer!');
            $email->htmlTemplate('mailer/users/add_user.html.twig')
                ->context([
                    'user'    => $user,
                    'url'     => $url,
                    'password'=> $password,
                ]);
            $this->mailer->send($email);
        } catch (\Exception $exception) {

        }
    }

    public function changePasswordUser(User $user, string $password)
    {
        try {
            $url   = $this->router->generate('admin_app_login', [], UrlGeneratorInterface::ABSOLUTE_URL);
            $email = (new TemplatedEmail())
                ->from('haikelbrinis@gmail.com')
                ->to($user->getEmail())
                ->subject('this is new Password!');
            $email->htmlTemplate('mailer/users/new_password.html.twig')
                ->context([
                    'user'    => $user,
                    'url'     => $url,
                    'password'=> $password,
                ]);
            $this->mailer->send($email);
        } catch (\Exception $exception) {
        }
    }
}