<?php
declare(strict_types=1);
namespace App\Http\Controller\Technology;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\TechnologyBuildOption;
use App\Domain\Categories\Entity\Technology;
use App\Domain\Categories\Form\TechnologyType;
/**
* @Route("/technology/create", name="technology_create",options = { "expose" = true })
*/
class CreateTechnologyController extends AbstractController
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Request $request):Response
    {
        $entity = new Technology();
        $form   = $this->createForm(TechnologyType::class, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($entity);
            $this->manager->flush();
            return $this->redirectToRoute('admin_technology');
        }
        return $this->render("Categories/technology/create.html.twig",['form'=>$form->createView()]);
    }
}