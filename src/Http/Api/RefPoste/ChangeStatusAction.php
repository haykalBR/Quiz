<?php

namespace App\Http\Api\RefPoste;

use App\Domain\User\Entity\RefPoste;
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
    public function __invoke(RefPoste $data ,Request  $request)
    {
        $result=json_decode($request->getContent(), true);
        $data->setEnabled($result['state']);
        $this->manager->flush();
        return new JsonResponse("data Update");
    }
}