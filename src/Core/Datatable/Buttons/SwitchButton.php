<?php

namespace App\Core\Datatable\Buttons;

class SwitchButton extends AbstractButtons
{

    private string $className;
    private string $label;
    private array $data;
    public function build()
    {
        $enabled=$this->data['t_enabled']==true?"true":"";
        $options= '<label  class="switch switch200">';
        if ($this->data['t_enabled'])
            $options.='<input  data-id="'.$this->data['t_id'].'"  type="checkbox" class="switch-input" checked >';
        else
            $options.='<input  data-id="'.$this->data['t_id'].'"  type="checkbox" class="switch-input" >';

        $options.='<span class="slider slider200"></span></label>';
        return $options;
    }
    public function addClassName(?string $className){
        $this->className =$className;
        return $this;
    }
    public function addLabel(?string $label){
        $this->label =$label;
        return $this;
    }
    public function addData(?array $data){
        $this->data =$data;
        return $this;
    }
}