<?php
namespace  App\Http\Controller\Reflevel;

use App\Core\Datatable\Factory\DataTableFactory;
use App\Domain\User\Entity\RefLevel;
use App\Domain\User\Form\RefLevelType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/levels/create", name="level_create")
 */
class CreateRefLevelController extends  AbstractController
{

    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    public function __invoke(Request  $request)
    {
        $reflevel=new RefLevel();
        $form   = $this->createForm(RefLevelType::class, $reflevel);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($reflevel);
            $this->manager->flush();
            return $this->redirectToRoute('admin_levels');
        }
        return $this->render('ref_level/create.html.twig',['form'=>$form->createView()]);
    }
}