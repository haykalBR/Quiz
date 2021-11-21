<?php
declare(strict_types=1);
namespace App\Http\Controller\User;
use App\Domain\User\Event\CreatePermissionRolesGroupFromUserEvent;
use App\Domain\User\Event\CreatePermissionsEvent;
use App\Domain\User\Event\MailAddUserEvent;
use App\Domain\User\Event\SuperAdminEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
    private UserPasswordHasherInterface $userPasswordHasher;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $manager,UserPasswordHasherInterface $userPasswordHasher,EventDispatcherInterface $eventDispatcher)
    {
        $this->manager = $manager;
        $this->userPasswordHasher = $userPasswordHasher;
        $this->eventDispatcher = $eventDispatcher;
    }
    public function __invoke(Request $request):Response
    {
        $user = new User();
        $form   = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                ));
           $this->manager->persist($user);
           $this->manager->flush();
            $this->eventDispatcher->dispatch(new CreatePermissionsEvent($user,$request->request->all()['user']));
            $this->eventDispatcher->dispatch(new CreatePermissionRolesGroupFromUserEvent($user, $user->getUserClone()));
            $this->eventDispatcher->dispatch(new MailAddUserEvent($user, $form->get('plainPassword')->getData()));
            return $this->redirectToRoute('admin_user');
        }
        return $this->render("User/user/create.html.twig",['form'=>$form->createView()]);
    }
}