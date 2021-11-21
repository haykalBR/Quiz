<?php

namespace App\Core\Services;

use Doctrine\ORM\EntityManagerInterface;

class IamService
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function getAnonymousRoutes($routes)
    {
        return preg_match("/^(_|fos_|app_|api_)\w+/", $routes);
    }

}