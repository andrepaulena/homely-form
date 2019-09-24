<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Number extends AbstractFormElement
{
    protected function renderFormElement() : string
    {
        return '<input type="number" '.$this->concatAttributesToElement().">";
    }
}
