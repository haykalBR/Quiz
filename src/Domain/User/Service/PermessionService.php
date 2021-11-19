<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 19/11/2021
 * Time: 15:49
 */
namespace App\Domain\User\Service;
use App\Domain\User\Repository\PermissionsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\RouterInterface;
class PermessionService
{
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;
    /**
     * @var RouterInterface
     */
    private RouterInterface $router;
    /**
     * @var PermissionsRepository
     */
    private PermissionsRepository $permissionsRepository;

    public function __construct(EntityManagerInterface $entityManager,RouterInterface $router,PermissionsRepository $permissionsRepository)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->permissionsRepository = $permissionsRepository;
    }

    /**
     * Creation permissions
     * @param $permissions
     */
    public function savePermission():void{
        foreach ($this->allGuardRoute() as $item){
            $permession=new Permissions();
            $permession->setGuardName($item);
            $permession->setName( str_replace('_', ' ', $item));
            $this->entityManager->persist($permession);
        }
        $this->entityManager->flush();
    }
    /**
     * get all guard name
     * @return array
     */
    public function allGuardRoute():array{
        return array_filter(array_keys($this->router->getRouteCollection()->all()), function ($value) {
            return preg_match('/admin_/', $value);
        });
    }
    /**
     * get new guard name
     * @return array
     */
    public function findNewGuardName():array{
        $new_guard=[];
        foreach ($this->permissionsRepository->findGuardName() as $guard){
            $new_guard[]=$guard['guardName'];
        }
        return array_diff($this->allGuardRoute(),$new_guard);
    }
}