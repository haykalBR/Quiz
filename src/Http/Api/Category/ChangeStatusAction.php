<?php

namespace App\Http\Api\Category;

use App\Domain\Category\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ChangeStatusAction extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }
    public function __invoke(Category $data ,Request  $request)
    {
        $result=json_decode($request->getContent(), true);
        $data->setPublic($result['state']);
        $this->manager->flush();
        return new JsonResponse("Compte Update");
    }
}