<?php

namespace App\Core\Datatable\Traits;

trait SimpleButtonTrait
{
    private string $className = "";
    private string $label = "";
    private array  $data;
    private string $icons = "";
    private string $route = "#";
    private array $params ;
    private string $width = "";
    public function addClassName(string $className)
    {
        $this->className = $className;

        return $this;
    }
    public function addLabel(string $label)
    {
        $this->label = $label;

        return $this;
    }
    public function addData(array $data)
    {
        $this->data = $data;

        return $this;
    }
    public function addIcon(string $icon):self
    {
        $this->icons = $icon;

        return $this;
    }
    public function addRoute(string $route):self
    {
        $this->route = $route;

        return  $this;
    }
    public function addWidth(string $width):self
    {
        $this->width = $width;

        return $this;
    }
    public function addParams(array  $params):self
    {
        $this->params = $params;

        return $this;
    }
    function buildClassName(...$className): string
    {
        $classe = "";
        foreach ($className as $item) {
            $classe .= $item." ";
        }

        return$classe;
    }
    function buildIcons(): void
    {
        if ($this->icons != "") {
            $this->icons = '<i class="'.$this->icons.'" aria-hidden="true"></i> ';
        }
    }
    function buildRoute(): void
    {
        if ($this->route != "#") {
            if (!empty($this->params)) {
                $this->route = $this->router->generate($this->route, $this->params);
            } else {
                $this->route = $this->router->generate($this->route);
            }
        }
    }
    function inslaize(): void
    {
        $this->className = "";
        $this->label = "";
        $this->data;
        $this->icons = "";
        $this->route = "#";
        $this->width = "";
    }
}