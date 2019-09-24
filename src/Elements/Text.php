<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Text extends AbstractFormElement
{
    protected function renderFormElement() : string
    {
        return '<input type="text" '.$this->concatAttributesToElement().">";
    }
}
