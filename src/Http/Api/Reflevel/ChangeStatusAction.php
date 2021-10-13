<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 13/10/2021
 * Time: 15:18
 */

namespace App\Http\Api\Reflevel;


use App\Entity\RefLevel;
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
    public function __invoke(RefLevel $data ,Request  $request)
    {

        $result=json_decode($request->getContent(), true);
        $data->setEnabled($result['state']);
        $this->manager->flush();
        return new JsonResponse("Compte Update");
    }

}