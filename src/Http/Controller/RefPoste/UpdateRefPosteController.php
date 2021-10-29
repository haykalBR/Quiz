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
* @Route("/refposte/update/{id}", name="refposte_update",options = { "expose" = true })
*/
class UpdateRefPosteController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(RefPoste $entity ,Request $request):Response
    {
        $form   = $this->createForm(RefPosteType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            return $this->redirectToRoute('admin_refposte');
        }
        return $this->render("User/ref_poste/edit.html.twig",['form'=>$form->createView()]);
    }
}