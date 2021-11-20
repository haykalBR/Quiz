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
* @Route("/user/update/{id}", name="user_update",options = { "expose" = true })
*/
class UpdateUserController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(User $entity ,Request $request):Response
    {
        $form   = $this->createForm(UserType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            return $this->redirectToRoute('admin_user');
        }
        return $this->render("User/user/edit.html.twig",['form'=>$form->createView()]);
    }
}