<?php
namespace App\Core\Datatable\Option;
class ExamBuildOption implements BuildOption
{

    const TYPE = "EXAM";
    public function render($data): string
    {
       return "";
    }

    public function support(string $type): bool
    {
        return  $type == self::TYPE;
    }
}