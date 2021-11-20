<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 22/10/2021
 * Time: 10:59
 */

namespace  App\Http\Controller\RefQuestionType;
use App\Domain\Question\Entity\RefQuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/refquestion/create", name="create_ref_question",options = { "expose" = true })
 */
class CreateRefQuestionTypeController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function __invoke(Request  $request)
    {
        $refquestion=new RefQuestionType();
        $form   = $this->createForm(\App\Form\RefQuestionType::class, $refquestion);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($refquestion);
            $this->manager->flush();
            return $this->redirectToRoute('admin_ref_question');
        }
        return $this->render('Question/ref_question_type/create.html.twig',['form'=>$form->createView()]);
    }

}