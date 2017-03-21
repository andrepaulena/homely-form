<?php
namespace MyForm\Elements;

use MyForm\Elements\Base\AbstractFormElement;

class Password extends AbstractFormElement
{
    protected function renderElement()
    {
        return '<input type="password" '.$this->prepareElement().">";
    }
}
