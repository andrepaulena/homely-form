<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class File extends AbstractFormElement
{
    protected function renderElement()
    {
        return '<input type="file" '.$this->concatAttributesToElement().">";
    }
}
