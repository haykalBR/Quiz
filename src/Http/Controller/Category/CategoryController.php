<?php
namespace  App\Http\Controller\Category;
use App\Core\Datatable\Factory\DataTable;
use App\Core\Datatable\Factory\DataTableFactory;
use App\Core\Datatable\Option\RefLevelBuildOption;
use App\Domain\Category\Entity\Category;
use App\Domain\User\Entity\RefLevel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/category", name="category",options = { "expose" = true })
 */
class CategoryController extends  AbstractController
{

    private DataTable $dataTable;

    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;
    }
    public function __invoke(Request $request)
    {
        if ($request->isXmlHttpRequest()){
            return  $this->json($this->dataTable->setEntity(RefLevel::class)->setTypeButtons(RefLevelBuildOption::TYPE)->dataTable());

        }
        return $this->render('category/index.html.twig');
    }
}