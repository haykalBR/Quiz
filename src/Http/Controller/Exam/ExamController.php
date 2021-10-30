<?php
declare(strict_types=1);
namespace App\Http\Controller\Exam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Core\Datatable\Factory\DataTable;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\ExamBuildOption;
use App\Domain\Exam\Entity\Exam;
/**
* @Route("/exam", name="exam",options = { "expose" = true })
*/
class ExamController extends AbstractController
{
    private DataTable $dataTable;
    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;

    }
    public function __invoke(Request $request):Response
    {
        if ($request->isXmlHttpRequest()){
            return  $this->json($this->dataTable->setEntity(Exam::class)->setTypeButtons(ExamBuildOption::TYPE)->execute());
        }
        return $this->render("Exam/exam/index.html.twig");
    }
}