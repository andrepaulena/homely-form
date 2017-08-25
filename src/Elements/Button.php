<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Button extends AbstractFormElement
{
    public function __construct($title)
    {
        parent::__construct($title);
        $this->label = null;
    }

    protected function renderElement()
    {
        $name = $this->getName();

        $this->removeAttribute('value');
        $this->removeAttribute('name');

        return "<button {$this->concatAttributesToElement()}>{$name}</button>";
    }

    public function setType($type)
    {
        $this->attributes['type'] = $type;

        return $this;
    }

    public function showValue()
    {
        return false;
    }
}
