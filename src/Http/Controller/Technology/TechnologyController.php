<?php
declare(strict_types=1);
namespace App\Http\Controller\Technology;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Core\Datatable\Factory\DataTable;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\TechnologyBuildOption;
use App\Domain\Categories\Entity\Technology;
/**
* @Route("/technology", name="technology",options = { "expose" = true })
*/
class TechnologyController extends AbstractController
{
    private DataTable $dataTable;
    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;

    }
    public function __invoke(Request $request):Response
    {
        if ($request->isXmlHttpRequest()){
            return  $this->json($this->dataTable->setEntity(Technology::class)->setTypeButtons(TechnologyBuildOption::TYPE)->execute());
        }
        return $this->render("Categories/technology/index.html.twig");
    }
}