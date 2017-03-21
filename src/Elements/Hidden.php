<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Hidden extends AbstractFormElement
{
    public function __construct($title)
    {
        $this->label = null;
        $this->elementName = $title;
    }

    protected function renderElement()
    {
        return '<input type="hidden" '.$this->prepareElement().">";
    }
}
