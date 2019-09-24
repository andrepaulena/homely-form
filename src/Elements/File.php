<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class File extends AbstractFormElement
{
    protected function renderFormElement() : string
    {
        return '<input type="file" '.$this->concatAttributesToElement().">";
    }
}
