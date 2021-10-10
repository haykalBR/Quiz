<?php
namespace App\Core\Datatable\Buttons;
use App\Core\Datatable\Buttons\AbstractButtons;
class SimpleButton extends AbstractButtons
{
    public static function build($className,$label): string
    {
        return "<buttons class='".$className."'>".$label."</buttons>";
    }
}