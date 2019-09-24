<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractElement;

class Label extends AbstractElement
{
    protected $label;

    public function __construct($label)
    {
        $this->label = $label;
    }

    public function getFor()
    {
        return $this->attributes['for']?$this->attributes['for']:null;
    }

    public function setFor($for)
    {
        $this->attributes['for'] = $for;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function renderElement() : string
    {
        return "<label ".$this->concatAttributesToElement().">{$this->label}</label>";
    }
}
