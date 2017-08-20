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
        return "<button {$this->concatAttributesToElement()}>{$this->getName()}</button>";
    }

    public function setType($type)
    {
        $this->attributes['type'] = $type;

        return $this;
    }
}
