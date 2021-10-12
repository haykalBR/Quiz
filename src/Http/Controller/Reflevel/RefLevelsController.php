<?php
namespace  App\Http\Controller\Reflevel;

use App\Core\Datatable\Factory\DataTableFactory;
use App\Entity\RefLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/levels", name="levels")
 */
class RefLevelsController extends  AbstractController
{
    /**
     * @var DataTableFactory
     */
    private DataTableFactory $dataTableFactory;
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;


    public function __construct(DataTableFactory $dataTableFactory,RequestStack $requestStack)
    {
        $this->dataTableFactory = $dataTableFactory;
        $this->requestStack = $requestStack;
    }

    public function __invoke() :Response
    {
        if ($this->requestStack->getCurrentRequest()->isXmlHttpRequest()){

            return  $this->json(this.$this->dataTableFactory(RefLevel::class));
        }
        return $this->render('ref_level/index.html.twig');
    }
}