<?php
declare(strict_types=1);
namespace App\Http\Controller\Permissions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\PermissionsBuildOption;
use App\Domain\User\Entity\Permissions;
use App\Domain\User\Form\PermissionsType;
/**
* @Route("/permissions/update/{id}", name="permissions_update",options = { "expose" = true })
*/
class UpdatePermissionsController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Permissions $entity ,Request $request):Response
    {
        $form   = $this->createForm(PermissionsType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            return $this->redirectToRoute('admin_permissions');
        }
        return $this->render("User/permissions/edit.html.twig",['form'=>$form->createView()]);
    }
}