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
         $options= '    <button type="button"  data-toggle="button" 
                     aria-pressed="true" autocomplete="off" ';

        $options.= $this->checked();
        $options .= '><div class="handle"></div></button>';
        return $options;
    }
}
