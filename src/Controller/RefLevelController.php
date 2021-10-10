<?php

namespace App\Controller;

use App\Core\Datatable\Factory\DataTableFactory;
use App\Entity\RefLevel;
use App\Repository\RefLevelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RefLevelController extends AbstractController
{

    /**
     * @var RefLevelRepository
     */
    private RefLevelRepository $levelRepository;

    public  function  __construct(RefLevelRepository $levelRepository)
    {
        $this->levelRepository = $levelRepository;
    }

    /**
     * @Route("/level", name="ref_level", methods={"GET","POST"},options={"expose"=true})
     */
    public function index(Request $request,DataTableFactory $dataTableFactory): Response
    {

        if ($request->isXmlHttpRequest()) {
            return $this->json($dataTableFactory->create(RefLevel::class), 200);
        }
        return $this->render('ref_level/index.html.twig', [
            'controller_name' => 'RefLevelController',
        ]);
    }
}
