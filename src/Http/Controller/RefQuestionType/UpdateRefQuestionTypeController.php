<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 22/10/2021
 * Time: 11:00
 */

namespace  App\Http\Controller\RefQuestionType;
use App\Domain\Question\Entity\RefQuestionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/refquestion/update/{id}", name="update_ref_question",options = { "expose" = true })
 */
class UpdateRefQuestionTypeController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function __invoke(RefQuestionType $questionType , Request  $request)
    {
        $form   = $this->createForm(\App\Form\RefQuestionType::class, $questionType);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            return $this->redirectToRoute('admin_ref_question');
        }
        return $this->render('Question/ref_question_type/create.html.twig',['form'=>$form->createView()]);
    }
}