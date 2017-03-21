<?php
namespace MyForm\Elements;

use MyForm\Elements\Base\AbstractFormElement;

class Text extends AbstractFormElement
{
    protected function renderElement()
    {
        return '<input type="text" '.$this->prepareElement().">";
    }
}
