<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Email extends AbstractFormElement
{
    protected function renderElement()
    {
        return '<input type="email" '.$this->prepareElement().">";
    }
}
