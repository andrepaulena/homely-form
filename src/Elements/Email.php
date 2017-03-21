<?php
namespace MyForm\Elements;

use MyForm\Elements\Base\AbstractFormElement;

class Email extends AbstractFormElement
{
    protected function renderElement()
    {
        return '<input type="email" '.$this->prepareElement().">";
    }
}
