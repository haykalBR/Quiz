<?php
namespace  App\Http\Controller\Reflevel;

use App\Core\Datatable\Factory\DataTable;
use App\Core\Datatable\Option\RefLevelBuildOption;
use App\Core\Datatable\Option\RegistryHandler;
use App\Domain\User\Entity\RefLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/levels", name="levels",options = { "expose" = true })
 */
class RefLevelsController extends  AbstractController
{

    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;
    private DataTable $dataTable;


    public function __construct(DataTable $dataTable,RequestStack $requestStack)
    {

        $this->requestStack = $requestStack;
        $this->dataTable = $dataTable;
    }

    public function __invoke() :Response
    {
        if ($this->requestStack->getCurrentRequest()->isXmlHttpRequest()){
            return  $this->json($this->dataTable->setEntity(RefLevel::class)->setTypeButtons(RefLevelBuildOption::TYPE)->execute());
        }
        return $this->render('User/ref_level/index.html.twig');
    }
}