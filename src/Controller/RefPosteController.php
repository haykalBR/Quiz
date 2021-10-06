<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RefPosteController extends AbstractController
{
    /**
     * @Route("/ref/poste", name="ref_poste")
     */
    public function index(): Response
    {
        return $this->render('ref_poste/index.html.twig', [
            'controller_name' => 'RefPosteController',
        ]);
    }
}
