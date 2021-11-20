<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 19/11/2021
 * Time: 15:45
 */
namespace App\Http\Api\Permissions;

use App\Domain\User\Service\PermessionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateNewGuardAction
{
    /**
     * @var PermessionService
     */
    private PermessionService $permessionService;

    /**
     * @param PermessionService $permessionService
     */
    public function __construct(PermessionService $permessionService)
    {
        $this->permessionService = $permessionService;
    }
    public function __invoke()
    {
        $permissions = $this->permessionService->findNewGuardName();
        if (empty($permissions)) {
            return  new JsonResponse('no permission added');
        }
        $this->permessionService->savePermission();
        return  new JsonResponse('all new permission added');
    }
}
