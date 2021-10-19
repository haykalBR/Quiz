<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Core\Services\CaptchaValidator;

class SecurityController extends AbstractController
{
    /**
     * @var CaptchaValidator
     */
    private $captchaValidator;

    public function __construct(CaptchaValidator $captchaValidator)
    {
        $this->captchaValidator = $captchaValidator;
    }
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error,'captchakey' => $this->captchaValidator->getKey()]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
    /**
     * @Route("/2fa", name="2fa_login")
     */
    public function check2Fa(): Response
    {
        return $this->render('security/2fa.html.twig');
    }
}
