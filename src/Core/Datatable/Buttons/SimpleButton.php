<?php
namespace App\Core\Datatable\Buttons;
use App\Core\Datatable\Buttons\AbstractButtons;
class SimpleButton extends AbstractButtons
{

    private string $className;
    private string $label;
    private array $data;
    public function build()
    {
        return  '<button type="button" class="'.$this->className.'" data-id="'.$this->data['t_id'].'">'.$this->label.'</button>';
    }
    public function addClassName(string $className){
        $this->className =$className;
        return $this;
    }
    public function addLabel(string $label){
        $this->label =$label;
        return $this;
    }
    public function addData(array $data){
        $this->data =$data;
        return $this;
    }
}