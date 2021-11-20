<?php
namespace App\Core\Datatable\Option;
class RolesBuildOption implements BuildOption
{

    const TYPE = "ROLES";
    public function render($data): string
    {
       return "";
    }

    public function support(string $type): bool
    {
        return  $type == self::TYPE;
    }
}