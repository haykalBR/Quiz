<?php
declare(strict_types=1);
namespace App\Http\Controller\Groupe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Core\Datatable\Factory\DataTable;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\GroupeBuildOption;
use App\Domain\User\Entity\Groupe;
/**
* @Route("/groupe", name="groupe",options = { "expose" = true })
*/
class GroupeController extends AbstractController
{
    private DataTable $dataTable;
    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;

    }
    public function __invoke(Request $request):Response
    {
        if ($request->isXmlHttpRequest()){
            return  $this->json($this->dataTable->setEntity(Groupe::class)->setTypeButtons(GroupeBuildOption::TYPE)->execute());
        }
        return $this->render("User/groupe/index.html.twig");
    }
}