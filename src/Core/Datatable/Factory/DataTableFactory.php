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
    /**
     * add interface
     * chouif factirykifech ye5dim
     * w add twig extension kifech direct datatable f twig
     * Datatbale functinalitte 9asimm mouch eli get DTO Request
     * add TYpe of Options
     * create Extesniontype switch w datepicker
     * add Form global for all forms in application
     * styling of page 2FA
     */
}