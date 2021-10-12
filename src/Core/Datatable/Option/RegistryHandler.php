<?php

namespace App\Core\Datatable\Option;

class RegistryHandler
{
    private $handlers;
    public function __construct(iterable $handlers)
    {
        $this->handlers = $handlers;
    }
    public function build(string $type,$data)
    {
        foreach ($this->handlers as $handler){
            if ($handler->support($type)){
                return $handler->render($data);
            }
        }
    }
}