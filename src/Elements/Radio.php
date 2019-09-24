<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class Radio extends AbstractFormElement
{
    protected function renderFormElement() : string
    {
        if (!$this->getValue()) {
            $this->setValue(1);
        }

        $element = '<input type="radio" '.$this->concatAttributesToElement().">";

        return $element;
    }

    public function setChecked($change = true)
    {
        $this->addAttribute('checked', $change);
    }

    public function setValueFromPost($value)
    {
        if (($this->getValue() === null && $value) || ($this->getValue() == $value)) {
            $this->setChecked();
        }

        return $this;
    }
}
