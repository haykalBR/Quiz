<?php

namespace App\Core\Datatable\Buttons;

abstract class AbstractButtons
{
    const PRIMARY="btn btn-primary";
    const secondary="btn btn-secondary";
    const SUCCESS="btn btn-success";
    const DANGER="btn btn-danger";
    const WARNING="btn btn-warning";
    const INFO="btn btn-info";
    const LIGHT="btn btn-light";
    const DARK="btn btn-dark";
    abstract  function build();
    /**
     * Feature lila
     * law wa7da fihom requierd w juste mouch order zada
     * add label
     * add className
     * addData
     * add icons
     * add isChecked
     * addRoute
     * addTaille(Button-switch-checkbox)
     *
     */
}