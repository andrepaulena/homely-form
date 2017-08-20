<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Hidden extends AbstractFormElement
{
    public function __construct($title)
    {
        parent::__construct($title);
        $this->label = null;
    }

    protected function renderElement()
    {
        return '<input type="hidden" '.$this->concatAttributesToElement().">";
    }
}
