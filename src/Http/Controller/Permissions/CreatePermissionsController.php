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
* @Route("/permissions/create", name="permissions_create",options = { "expose" = true })
*/
class CreatePermissionsController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Request $request):Response
    {
        $entity = new Permissions();
        $form   = $this->createForm(PermissionsType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($entity);
            $this->manager->flush();
            return $this->redirectToRoute('admin_permissions');
        }
        return $this->render("User/permissions/create.html.twig",['form'=>$form->createView()]);
    }
}