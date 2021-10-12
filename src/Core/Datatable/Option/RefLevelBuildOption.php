<?php

namespace App\Core\Datatable\Option;

use App\Core\Datatable\Buttons\SimpleButton;

class RefLevelBuildOption implements BuildOption
{
    const TYPE="level";
    public function render($data): string
    {
        //a modifer
       $options=SimpleButton::build("btn btn-info delete",'Delete',$data).' ';
       $options.=SimpleButton::build("btn",'info',$data);
       return  $options;
    }
    public function support(string $type): bool
    {
        return  $type==self::TYPE;
    }
}