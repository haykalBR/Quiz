<?php

namespace App\Core\Datatable\Factory;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class DataTableFactory
{

    private DataTable $dataTable;
    public function __construct(DataTable $dataTable)
    {
        $this->dataTable = $dataTable;
    }
    public function create($className){
        return $this->dataTable->dataTable($className);;
    }
}