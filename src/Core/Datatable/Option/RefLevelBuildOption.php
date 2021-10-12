<?php

namespace App\Core\Datatable\Option;

use App\Core\Datatable\Buttons\SimpleButton;

class RefLevelBuildOption extends AbstractBuildOption
{
    const TYPE="level";
    public function render(): string
    {
       $options=SimpleButton::build("btn btn-info",'Edit').' ';
       $options.=SimpleButton::build("btn",'info');
       return "";
    }

    public function support(string $media): bool
    {
        return  $media==self::TYPE;
    }
}