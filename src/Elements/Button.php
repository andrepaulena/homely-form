<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Button extends AbstractFormElement
{
    public function __construct($title)
    {
        $this->elementName = $title;
        $this->name = $title;
    }

    protected $type = 'button';

    protected $title = '';

    protected function renderElement()
    {
        return "<button type='{$this->type}' {$this->concatAttributesToElement()}>{$this->title}</button>";
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }
}
