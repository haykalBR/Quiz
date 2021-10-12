<?php

namespace App\Core\Datatable\Option;

use App\Core\Datatable\Buttons\SimpleButton;

class RefLevelOption extends AbstractOption
{


    public function render(): string
    {
       $options=SimpleButton::build("btn btn-info",'Edit').' ';
       $options.=SimpleButton::build("btn",'info');
       return $options;
    }
}