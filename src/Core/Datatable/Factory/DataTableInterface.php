<?php

namespace App\Core\Datatable\Factory;

use Doctrine\ORM\QueryBuilder;

interface DataTableInterface
{

    function getTotalRecords():int;
    function getRecordsFiltered():int;
    function setEntity($entity_name):self;
    function setTypeButtons($type_button):self;
    function setSearch(QueryBuilder $filteredTotal):QueryBuilder;
    function execute():array;
}