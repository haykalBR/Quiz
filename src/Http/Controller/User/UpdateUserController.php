<?php
declare(strict_types=1);
namespace App\Http\Controller\User;
use App\Domain\User\Event\CreatePermissionRolesGroupFromUserEvent;
use App\Domain\User\Event\SuperAdminEvent;
use App\Domain\User\Event\UpdateGroupEvent;
use App\Domain\User\Event\UpdatePermissionsEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
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
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $manager,EventDispatcherInterface $eventDispatcher)
    {
        $this->manager = $manager;
        $this->eventDispatcher = $eventDispatcher;
    }
    public function __invoke(User $user ,Request $request):Response
    {
        $form   = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            if (count($user->getRole())>0){
                $this->eventDispatcher->dispatch(new UpdatePermissionsEvent($user,$request->request->all()['user']));
            }
            if ($user->getUserClone()){
                $this->eventDispatcher->dispatch(new CreatePermissionRolesGroupFromUserEvent($user, $user->getUserClone()));
            }
            if (count($user->getGroupes())>0){
                $this->eventDispatcher->dispatch((new UpdateGroupEvent($user)));
            }
            return $this->redirectToRoute('admin_user');
        }
        return $this->render("User/user/edit.html.twig",['form'=>$form->createView()]);
    }
}