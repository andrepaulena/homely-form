<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Number extends AbstractFormElement
{
    protected function renderElement()
    {
        return '<input type="number" '.$this->concatAttributesToElement().">";
    }
}
