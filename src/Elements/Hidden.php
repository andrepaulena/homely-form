<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Hidden extends AbstractFormElement
{
    public function __construct($name)
    {
        parent::__construct($name);
        $this->label = null;
    }

    protected function renderFormElement() : string
    {
        return '<input type="hidden" '.$this->concatAttributesToElement().">";
    }
}
