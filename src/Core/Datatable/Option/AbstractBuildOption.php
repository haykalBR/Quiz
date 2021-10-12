<?php

namespace App\Core\Datatable\Option;

abstract  class AbstractBuildOption
{
    abstract public function render():string;
    abstract public function support(string $media): bool;
}