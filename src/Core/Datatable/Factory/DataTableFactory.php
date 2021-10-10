<?php

namespace App\Core\Datatable\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class DataTableFactory
{
    private Request $requestStack;
    private EntityManagerInterface $manager;


    public function __construct(RequestStack $requestStack,EntityManagerInterface  $manager)
    {
        $this->requestStack = $requestStack->getCurrentRequest();

        $this->manager = $manager;
    }
    public function create($className){

        return (new DataTable($this->requestStack,$this->manager))
            ->dataTable($className);;
    }



}