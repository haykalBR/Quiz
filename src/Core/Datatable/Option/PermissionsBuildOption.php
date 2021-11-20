<?php
namespace App\Core\Datatable\Option;
class PermissionsBuildOption implements BuildOption
{

    const TYPE = "PERMISSIONS";
    public function render($data): string
    {
       return "";
    }

    public function support(string $type): bool
    {
        return  $type == self::TYPE;
    }
}