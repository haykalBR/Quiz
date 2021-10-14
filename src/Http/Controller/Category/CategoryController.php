<?php
namespace  App\Http\Controller\Category;
use App\Core\Datatable\Factory\DataTableFactory;
use App\Domain\Category\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/category", name="category",options = { "expose" = true })
 */
class CategoryController extends  AbstractController
{
    private DataTableFactory $dataTableFactory;

    public function __construct(DataTableFactory $dataTableFactory)
    {
        $this->dataTableFactory = $dataTableFactory;
    }
    public function __invoke(Request $request)
    {
        if ($request->isXmlHttpRequest()){
            return $this->json($this->dataTableFactory->create(Category::class));
        }
        return $this->render('category/index.html.twig');
    }
}