<?php

namespace App\Core\Datatable\Factory;

use Doctrine\ORM\QueryBuilder;

interface DataTableInterface
{

    function getTotalRecords(QueryBuilder $total):int;
    function getRecordsFiltered(QueryBuilder $filteredTotal):int;
    function setEntity($entity_name):self;
    function setTypeButtons($type_button):self;
    function setSearch(QueryBuilder $filteredTotal):QueryBuilder;
    function setcustomSearch(QueryBuilder $customSearch):QueryBuilder;
    function execute():array;
}