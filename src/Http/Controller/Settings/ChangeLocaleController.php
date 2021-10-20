<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 19/10/2021
 * Time: 14:23
 */

namespace App\Http\Controller\Settings;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/settings/change-locale/{locale}", name="settings_change_locale",options = { "expose" = true })
 */
class ChangeLocaleController extends AbstractController
{
     public function __invoke(string $locale, Request $request):Response
     {
         $request->getSession()->set('_locale',$locale);
         return $this->redirect($request->headers->get('referer'));
     }

}