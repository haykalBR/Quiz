<?php
namespace App\Core\Datatable\Option;
class GroupeBuildOption implements BuildOption
{

    const TYPE = "GROUPE";
    public function render($data): string
    {
       return "";
    }

    public function support(string $type): bool
    {
        return  $type == self::TYPE;
    }
}