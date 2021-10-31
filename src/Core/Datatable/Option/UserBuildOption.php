<?php
namespace App\Core\Datatable\Option;
class UserBuildOption implements BuildOption
{

    const TYPE = "USER";
    public function render($data): string
    {
       return "";
    }

    public function support(string $type): bool
    {
        return  $type == self::TYPE;
    }
}