<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class CheckBox extends AbstractFormElement
{
    /** @var Hidden */
    protected $unchecked;

    protected function renderFormElement() : string
    {
        if (!$this->unchecked) {
            $this->setUncheckedValue(0);
        }

        if (!$this->getValue()) {
            $this->setValue(1);
        }

        if ($this->getValue() == $this->unchecked->getValue()) {
            $this->setChecked(false);
        }

        $element = $this->unchecked->renderElement();
        $element .= '<input type="checkbox" '.$this->concatAttributesToElement().">";

        return $element;
    }

    public function setChecked($change = true)
    {
        $this->addAttribute('checked', $change);
    }

    public function setUncheckedValue($value)
    {
        $this->unchecked = new Hidden($this->getName());
        $this->unchecked->setValue($value);

        return $this;
    }

    public function setCheckedValue($value)
    {
        $this->setValue($value);

        return $this;
    }

    public function setValueFromPost($value)
    {
        if (($this->getValue() === null && $value) || ($this->getValue() == $value)) {
            $this->setChecked();
        }

        return $this;
    }
}
