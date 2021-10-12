<?php

namespace App\Core\Datatable\Buttons;

abstract class AbstractButtons
{
    abstract public static function build($className,$label,$data):string;
}