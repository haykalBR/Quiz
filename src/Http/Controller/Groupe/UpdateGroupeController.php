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
* @Route("/groupe/update/{id}", name="groupe_update",options = { "expose" = true })
*/
class UpdateGroupeController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Groupe $entity ,Request $request):Response
    {
        $form   = $this->createForm(GroupeType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            return $this->redirectToRoute('admin_groupe');
        }
        return $this->render("User/groupe/edit.html.twig",['form'=>$form->createView()]);
    }
}