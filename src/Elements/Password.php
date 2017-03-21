<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Password extends AbstractFormElement
{
    protected function renderElement()
    {
        return '<input type="password" '.$this->prepareElement().">";
    }
}
