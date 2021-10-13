<?php

namespace App\Core\Datatable\Option;

use App\Core\Datatable\Buttons\AbstractButtons;
use App\Core\Datatable\Buttons\SimpleButton;
use App\Core\Datatable\Buttons\SwitchButton;

class RefLevelBuildOption implements BuildOption
{
    const TYPE="level";
    public function render($data): string
    {
        $options="";
        $simpleButton =new SimpleButton();
        $switchButton =new SwitchButton();
        $options.=$simpleButton->addClassName(AbstractButtons::DANGER." delete")->addData($data)->addLabel('Delete')->build();
        $options.=$switchButton->addData($data)->build();
        return  $options;
    }
    public function support(string $type): bool
    {
        return  $type==self::TYPE;
    }
}