<?php
declare(strict_types=1);
namespace App\Http\Controller\RefPoste;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Core\Datatable\Factory\DataTable;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\RefPosteTypeOption;
use App\Domain\User\Entity\RefPoste;
/**
* @Route("/refposte", name="refposte",options = { "expose" = true })
*/
class RefPosteController extends AbstractController
{
    private DataTable $dataTable;
    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;

    }
    public function __invoke(Request $request):Response
    {
        if ($request->isXmlHttpRequest()){
            return  $this->json($this->dataTable->setEntity(RefPoste::class)->setTypeButtons(RefPosteTypeOption::TYPE)->execute());
        }
        return $this->render("User/refposte/index.html.twig");
    }
}