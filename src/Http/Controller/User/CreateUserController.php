<?php
declare(strict_types=1);
namespace App\Http\Controller\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\UserBuildOption;
use App\Domain\User\Entity\User;
use App\Domain\User\Form\UserType;
/**
* @Route("/user/create", name="user_create",options = { "expose" = true })
*/
class CreateUserController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Request $request):Response
    {
        $entity = new User();
        $form   = $this->createForm(UserType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($entity);
            $this->manager->flush();
            return $this->redirectToRoute('admin_user');
        }
        return $this->render("User/user/create.html.twig",['form'=>$form->createView()]);
    }
}