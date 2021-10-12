<?php
namespace App\Core\Datatable\Buttons;
use App\Core\Datatable\Buttons\AbstractButtons;
class SimpleButton extends AbstractButtons
{
    public static function build($className,$label,$data): string
    {

        return "<buttons class='".$className."' data-id=".$data['t_id'].">".$label."</buttons>";
    }
}