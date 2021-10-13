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
        $options.=$simpleButton->addClassName(AbstractButtons::DANGER." delete")->addData($data)->addLabel('Delete')->build();
        $options.='  <label  class="switch switch200">
    <input data-id="'.$data['t_id'].'" type="checkbox" class="switch-input">
    <span class="slider slider200"></span>
  </label>';
        return  $options;
    }
    public function support(string $type): bool
    {
        return  $type==self::TYPE;
    }
}