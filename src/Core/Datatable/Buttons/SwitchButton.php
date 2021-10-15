<?php

namespace App\Core\Datatable\Buttons;

use App\Core\Datatable\Traits\SimpleButtonTrait;
use App\Core\Datatable\Traits\SwitchButtonTrait;

class SwitchButton extends AbstractButtons
{
    use SimpleButtonTrait;
    use SwitchButtonTrait;

    public function build()
    {
        $options = '<label  class="switch switch200">';
        $options .= $this->checked();
        $options .= '<span class="slider slider200"></span></label>';
        return $options;
    }
}
