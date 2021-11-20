<?php

namespace App\Http\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/dashboard", name="dashboard",options = { "expose" = true })
 */
class DashboardController extends AbstractController
{

    public function __invoke()
    {
        return $this->render('Dashboard/dashboard/index.html.twig');

    }

}