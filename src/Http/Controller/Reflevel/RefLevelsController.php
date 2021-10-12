<?php
namespace  App\Http\Controller\Reflevel;

use App\Core\Datatable\Factory\DataTableFactory;
use App\Core\Datatable\Option\RegistryHandler;
use App\Entity\RefLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/levels", name="levels",options = { "expose" = true })
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
    private RegistryHandler $handler;


    public function __construct(DataTableFactory $dataTableFactory,RequestStack $requestStack,RegistryHandler  $handler)
    {
        $this->dataTableFactory = $dataTableFactory;
        $this->requestStack = $requestStack;
        $this->handler = $handler;
    }

    public function __invoke() :Response
    {

        if ($this->requestStack->getCurrentRequest()->isXmlHttpRequest()){


            return  $this->json($this->dataTableFactory->create(RefLevel::class));
        }
        return $this->render('ref_level/index.html.twig');
    }
}