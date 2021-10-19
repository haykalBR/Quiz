<?php
namespace  App\Http\Controller\Categories;
use App\Core\Datatable\Factory\DataTableFactory;
use App\Domain\Categories\Entity\Categories;
use App\Form\CategoriesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category/create", name="category_create")
 */
class CreateCategoriesController extends AbstractController
{

    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Request $request)
    {
        $categories = new Categories();
        $form   = $this->createForm(CategoriesType::class, $categories);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($categories);
            $this->manager->flush();
            return $this->redirectToRoute('admin_category');
        }
        return $this->render('Categories/categories/create.html.twig',['form'=>$form->createView()]);
    }
}