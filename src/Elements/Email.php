<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Email extends AbstractFormElement
{
    protected function renderFormElement() : string
    {
        return '<input type="email" '.$this->concatAttributesToElement().">";
    }
}
