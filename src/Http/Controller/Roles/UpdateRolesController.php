<?php
declare(strict_types=1);
namespace App\Http\Controller\Roles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\RolesBuildOption;
use App\Domain\User\Entity\Roles;
use App\Domain\User\Form\RolesType;
/**
* @Route("/roles/update/{id}", name="roles_update",options = { "expose" = true })
*/
class UpdateRolesController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Roles $entity ,Request $request):Response
    {
        $form   = $this->createForm(RolesType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            return $this->redirectToRoute('admin_roles');
        }
        return $this->render("User/roles/edit.html.twig",['form'=>$form->createView()]);
    }
}