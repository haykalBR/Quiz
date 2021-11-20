<?php
declare(strict_types=1);
namespace App\Http\Controller\Permissions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Core\Datatable\Factory\DataTable;
use Symfony\Component\HttpFoundation\Request;
use App\Core\Datatable\Option\PermissionsBuildOption;
use App\Domain\User\Entity\Permissions;
/**
* @Route("/permissions", name="permissions",options = { "expose" = true })
*/
class PermissionsController extends AbstractController
{
    private DataTable $dataTable;
    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;

    }
    public function __invoke(Request $request):Response
    {
        if ($request->isXmlHttpRequest()){
            return  $this->json($this->dataTable->setEntity(Permissions::class)->setTypeButtons(PermissionsBuildOption::TYPE)->execute());
        }
        return $this->render("User/permissions/index.html.twig");
    }
}