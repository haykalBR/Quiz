<?php

namespace App\Core\Datatable\Option;

interface BuildOption
{
     public function render($data):string;
     public function support(string $type): bool;
}