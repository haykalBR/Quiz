<?php

namespace App\Core\Datatable\Option;

use App\Core\Datatable\Buttons\AbstractButtons;
use App\Core\Datatable\Buttons\SimpleButton;

class RefLevelBuildOption implements BuildOption
{
    const TYPE="level";
    public function render($data): string
    {
        $options="";
        $simpleButton =new SimpleButton();
        $options.=$simpleButton->addClassName(AbstractButtons::DANGER)->addData($data)->addLabel('Delete')->build();
        return  $options;
    }
    public function support(string $type): bool
    {
        return  $type==self::TYPE;
    }
}