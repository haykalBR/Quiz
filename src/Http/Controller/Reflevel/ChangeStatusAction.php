<?php
/**
 * Created by PhpStorm.
 * User: Haykel.Brinis
 * Date: 13/10/2021
 * Time: 15:18
 */

namespace App\Http\Controller\Reflevel;


use App\Entity\RefLevel;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function __invoke(RefLevel $data)
    {
        dd($data->getId());

    }

}