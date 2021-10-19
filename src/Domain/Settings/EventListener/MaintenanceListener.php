<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 19/10/2021
 * Time: 23:20
 */
namespace App\Domain\Settings\EventListener;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Twig\Environment;

class MaintenanceListener
{
    private Environment $twig;

    public function __construct( Environment $twig){
        $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event){
        if (true)  return;
        $event->setResponse(
            new Response(
                $this->twig->render('settings/maintenance/maintenance.html.twig'),
                Response::HTTP_SERVICE_UNAVAILABLE
            )
        );
        $event->stopPropagation();
    }
}