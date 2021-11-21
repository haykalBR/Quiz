<?php
namespace App\Core\Datatable\Option;
use App\Core\Datatable\Buttons\AbstractButtons;
use App\Core\Datatable\Buttons\SimpleButton;
use App\Core\Datatable\Buttons\SwitchButton;

class GroupeBuildOption implements BuildOption
{

    const TYPE = "GROUPE";
    private SwitchButton $switchButton;
    private SimpleButton $simpleButton;

    public function __construct(SwitchButton $switchButton, SimpleButton $simpleButton)
    {
        $this->switchButton = $switchButton;
        $this->simpleButton = $simpleButton;
    }
    public function render($data): string
    {
        $options = "";
        $options .= $this->simpleButton->addClassName(AbstractButtons::DANGER." delete")
            ->addLabel('Delete')
            ->addData($data)
            ->addWidth("btn-lg")
            ->build();
        $options .= $this->simpleButton->addLabel('Edit')
            ->addClassName(AbstractButtons::WARNING)
            ->addRoute('admin_groupe_update')
            ->addParams(['id' => $data['t_id']])
            ->addWidth("btn-lg")
            ->build();
        return  $options;
    }
    public function support(string $type): bool
    {
        return  $type == self::TYPE;
    }
}