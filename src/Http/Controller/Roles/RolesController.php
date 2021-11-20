<?php
declare(strict_types=1);
namespace App\Http\Controller\Roles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Core\Datatable\Factory\DataTable;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\RolesBuildOption;
use App\Domain\User\Entity\Roles;
/**
* @Route("/roles", name="roles",options = { "expose" = true })
*/
class RolesController extends AbstractController
{
    private DataTable $dataTable;
    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;

    }
    public function __invoke(Request $request):Response
    {
        if ($request->isXmlHttpRequest()){
            return  $this->json($this->dataTable->setEntity(Roles::class)->setTypeButtons(RolesBuildOption::TYPE)->execute());
        }
        return $this->render("User/roles/index.html.twig");
    }
}