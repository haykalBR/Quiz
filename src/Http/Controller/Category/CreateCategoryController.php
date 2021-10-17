<?php
namespace  App\Http\Controller\Category;
use App\Core\Datatable\Factory\DataTableFactory;
use App\Domain\Category\Entity\Category;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category/create", name="category_create")
 */
class CreateCategoryController extends AbstractController
{

    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Request $request)
    {
        $category = new Category();
        $form   = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->persist($category);
            $this->manager->flush();
            return $this->redirectToRoute('admin_category');
        }
        return $this->render('category/create.html.twig',['form'=>$form->createView()]);


    }
}