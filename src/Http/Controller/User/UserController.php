<?php
declare(strict_types=1);
namespace App\Http\Controller\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Core\Datatable\Factory\DataTable;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\UserBuildOption;
use App\Domain\User\Entity\User;
/**
* @Route("/user", name="user",options = { "expose" = true })
*/
class UserController extends AbstractController
{
    private DataTable $dataTable;
    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;

    }
    public function __invoke(Request $request):Response
    {
        if ($request->isXmlHttpRequest()){
            return  $this->json($this->dataTable->setEntity(User::class)->setTypeButtons(UserBuildOption::TYPE)->execute());
        }
        return $this->render("User/user/index.html.twig");
    }
}