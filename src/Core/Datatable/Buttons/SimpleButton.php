<?php
namespace App\Core\Datatable\Buttons;

use App\Core\Datatable\Buttons\AbstractButtons;
use App\Core\Datatable\Traits\SimpleButtonTrait;
use Symfony\Component\Routing\RouterInterface;

class SimpleButton extends AbstractButtons
{
    use SimpleButtonTrait;
    private RouterInterface $router;
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }
    public function build()
    {
        $classes = $this->buildClassName($this->className, $this->width);
        $this->buildRoute();
        $this->buildIcons();
        $button = ' <a href="'.$this->route.'" type="button" class="'.$classes.'" data-id="'.$this->data['t_id'].'">'.$this->icons." ".$this->label.'</a>';
        $this->inslaize();

        return $button;
    }


}
