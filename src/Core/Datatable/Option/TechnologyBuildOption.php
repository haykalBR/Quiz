<?php
namespace App\Core\Datatable\Option;
class TechnologyBuildOption implements BuildOption
{

    const TYPE = "TECHNOLOGY";
    public function render($data): string
    {
       return "";
    }

    public function support(string $type): bool
    {
        return  $type == self::TYPE;
    }
}