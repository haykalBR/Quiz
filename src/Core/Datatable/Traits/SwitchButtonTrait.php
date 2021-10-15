<?php

namespace App\Core\Datatable\Traits;

trait SwitchButtonTrait
{
    private string $parmsChecked;
    public function addParmsChecked(string $parmsChecked): self
    {
        $this->parmsChecked = $parmsChecked;

        return $this;
    }
    public function checked():string
    {
        if ($this->data[$this->parmsChecked]) {
            return '<input  data-id="'.$this->data['t_id'].'"  type="checkbox" class="switch-input" checked >';
        }

        return '<input  data-id="'.$this->data['t_id'].'"  type="checkbox" class="switch-input" >';
    }
}
