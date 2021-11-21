<?php
declare(strict_types=1);
namespace App\Http\Controller\Groupe;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\GroupeBuildOption;
use App\Domain\User\Entity\Groupe;
use App\Domain\User\Form\GroupeType;
/**
* @Route("/groupe/create", name="groupe_create",options = { "expose" = true })
*/
class CreateGroupeController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Request $request):Response
    {
        $entity = new Groupe();
        $form   = $this->createForm(GroupeType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($entity);
            $this->manager->flush();
            return $this->redirectToRoute('admin_groupe');
        }
        return $this->render("User/groupe/create.html.twig",['form'=>$form->createView()]);
    }
}