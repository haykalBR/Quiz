<?php
namespace  App\Http\Controller\Categories;

use App\Domain\Categories\Entity\Categories;
use App\Form\CategoriesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/category/update/{id}", name="category_update")
 */
class UpdateCategoriesController extends AbstractController
{

    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Categories $categories ,Request $request)
    {
        $form   = $this->createForm(CategoriesType::class, $categories);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->manager->flush();
            return $this->redirectToRoute('admin_category');
        }
        return $this->render('Categories/categories/edit.html.twig',['form'=>$form->createView()]);
    }

}