<?php

namespace App\Core\Datatable\Option;

class CategoryBuildOption implements BuildOption
{
    const TYPE="category";
    public function render($data): string
    {
        return "";
    }

    public function support(string $type): bool
    {
        return  $type==self::TYPE;
    }
}