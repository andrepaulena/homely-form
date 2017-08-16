<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class TextArea extends AbstractFormElement
{
    protected $options = [];

    protected $multiple = false;

    protected function renderElement()
    {
        $multiple = $this->multiple?'multiple ':'';

        $element =  '<select '.$multiple.$this->concatAttributesToElement().'>';

        foreach ($this->options as $key => $value) {
            $element .= "<option value='{$key}'>{$value}</option>";
        }

        $element .= '</select>';

        return $element;
    }

    public function setOptions($options)
    {
        if (is_array($options)) {
            $this->options = $options;
        }

        return $this;
    }

    public function addOption($key, $value)
    {
        $this->options[$key] = $value;

        return $this;
    }

    public function removeOption($key)
    {
        if (isset($this->options[$key])) {
            unset($this->options[$key]);
        }

        return $this;
    }

    public function setMultiple($multiple = true)
    {
        $this->multiple = $multiple;
    }
}
