<?php
namespace  App\Controller\Level;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/level/create", name="level_create")
 */
class CreateRefLevelController extends  AbstractController
{
    public function __invoke()
    {
        dd(555);
    }
}