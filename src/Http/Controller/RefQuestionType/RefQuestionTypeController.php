<?php
namespace  App\Http\Controller\RefQuestionType;
use App\Core\Datatable\Factory\DataTable;
use App\Core\Datatable\Option\RefLevelBuildOption;
use App\Domain\Question\Entity\RefQuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/refquestion", name="ref_question",options = { "expose" = true })
 */
class RefQuestionTypeController extends AbstractController
{
    /**
     * @var DataTable
     */
    private DataTable $dataTable;

    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;
    }
    public function __invoke(Request $request):Response
    {
        if ($request->isXmlHttpRequest()){
            return $this->json($this->dataTable->setEntity(RefQuestionType::class)->setTypeButtons(RefLevelBuildOption::TYPE)->execute());
        }
        return $this->render('Question/ref_question_type/index.html.twig');
    }

}