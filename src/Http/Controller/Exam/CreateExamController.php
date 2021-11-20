<?php
declare(strict_types=1);
namespace App\Http\Controller\Exam;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\ExamBuildOption;
use App\Domain\Exam\Entity\Exam;
use App\Domain\Exam\Form\ExamType;
/**
* @Route("/exam/create", name="exam_create",options = { "expose" = true })
*/
class CreateExamController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Request $request):Response
    {
        $entity = new Exam();
        $form   = $this->createForm(ExamType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($entity);
            $this->manager->flush();
            return $this->redirectToRoute('admin_exam');
        }
        return $this->render("Exam/exam/create.html.twig",['form'=>$form->createView()]);
    }
}