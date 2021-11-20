<?php

namespace App\Http\Api\Users;

use App\Domain\User\Repository\PermissionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class GetPermissionFromRolesAction extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private PermissionsRepository $permissionsRepository;

    public function __construct(EntityManagerInterface $entityManager,PermissionsRepository $permissionsRepository)
    {
        $this->entityManager = $entityManager;
        $this->permissionsRepository = $permissionsRepository;
    }
    public function __invoke(Request $request)
    {
        $result=json_decode($request->getContent(), true);
        if (!key_exists('roles',$result,)){
            throw  new \Exception(400,ApiProblem::TYPE_INVALID_REQUEST_BODY_FORMAT);
        }
        $permissionsGrant=$this->permissionsRepository->getPermissionNotInRoles($result['roles']);
        $permissionsRevoke=$this->permissionsRepository->getPermissionFromRoles($result['roles']);
        return $this->json( ['grant'=>$permissionsGrant,'revoke'=>$permissionsRevoke],200);
    }
}