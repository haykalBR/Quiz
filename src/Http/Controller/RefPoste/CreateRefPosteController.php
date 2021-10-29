<?php
declare(strict_types=1);
namespace App\Http\Controller\RefPoste;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\RefPosteBuildOption;
use App\Domain\User\Entity\RefPoste;
use App\Domain\User\Form\RefPosteType;
/**
* @Route("/refposte/create", name="refposte_create",options = { "expose" = true })
*/
class CreateRefPosteController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Request $request):Response
    {
        $entity = new RefPoste();
        $form   = $this->createForm(RefPosteType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($entity);
            $this->manager->flush();
            return $this->redirectToRoute('admin_category');
        }
        return $this->render("User/ref_poste/create.html.twig",['form'=>$form->createView()]);
    }
}