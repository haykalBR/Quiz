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
            return ' data-id="'.$this->data['t_id'].'"  class="btn btn-lg btn-toggle switch-input active"';
        }
        return ' data-id="'.$this->data['t_id'].'"  class="btn btn-lg btn-toggle switch-input"';
    }
}
