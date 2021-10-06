<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RefQuestionTypeController extends AbstractController
{
    /**
     * @Route("/ref/question/type", name="ref_question_type")
     */
    public function index(): Response
    {
        return $this->render('ref_question_type/index.html.twig', [
            'controller_name' => 'RefQuestionTypeController',
        ]);
    }
}
