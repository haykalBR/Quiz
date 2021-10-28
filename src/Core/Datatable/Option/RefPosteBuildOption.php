<?php
namespace App\Core\Datatable\Option;
class RefPosteTypeOption implements BuildOption
{

    const TYPE = "REFPOSTE";
    public function render($data): string
    {
       return "";
    }

    public function support(string $type): bool
    {
        return  $type == self::TYPE;
    }
}