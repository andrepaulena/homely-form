<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractFormElement;

class TextArea extends AbstractFormElement
{
    protected function renderFormElement() : string
    {
        $value = $this->getValue();
        $this->removeAttribute('value');

        return '<textarea '.$this->concatAttributesToElement().'>'.$value.'</textarea>';
    }

    public function setRows($rows)
    {
        $this->addAttribute('rows', $rows);
    }

    public function setCols($cols)
    {
        $this->addAttribute('cols', $cols);
    }
}
