<?php
namespace  App\Http\Controller\Reflevel;


use App\Domain\User\Entity\RefLevel;
use App\Domain\User\Form\RefLevelType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/levels/update/{id}", name="level_update")
 */
class UpdateReflevelController extends  AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function __invoke(RefLevel $refLevel , Request  $request)
    {
        $form   = $this->createForm(RefLevelType::class, $refLevel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            return $this->redirectToRoute('admin_levels');
        }
        return $this->render('User/ref_level/edit.html.twig',['form'=>$form->createView()]);
    }
}