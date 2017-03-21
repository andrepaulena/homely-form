<?php
namespace MyForm\Elements;

use MyForm\Elements\Base\AbstractFormElement;

class Number extends AbstractFormElement
{
    protected function renderElement()
    {
        return '<input type="number" '.$this->prepareElement().">";
    }
}
