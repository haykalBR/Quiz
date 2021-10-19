<?php
namespace  App\Http\Controller\Categories;
use App\Core\Datatable\Factory\DataTable;
use App\Core\Datatable\Factory\DataTableFactory;
use App\Core\Datatable\Option\CategoriesBuildOption;
use App\Domain\Categories\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/category", name="category",options = { "expose" = true })
 */
class CategoriesController extends  AbstractController
{

    private DataTable $dataTable;

    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;
    }
    public function __invoke(Request $request)
    {
        if ($request->isXmlHttpRequest()){
            return  $this->json($this->dataTable->setEntity(Categories::class)->setTypeButtons(CategoriesBuildOption::TYPE)->execute());

        }
        return $this->render('Categories/categories/index.html.twig');
    }
}