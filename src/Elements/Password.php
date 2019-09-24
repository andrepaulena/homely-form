<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Password extends AbstractFormElement
{
    protected function renderFormElement() : string
    {
        return '<input type="password" '.$this->concatAttributesToElement().">";
    }
}
