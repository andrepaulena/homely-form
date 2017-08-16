<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractElement;

class Label extends AbstractElement
{
    public function __construct($name)
    {
        $this->name = $name;
    }

    protected $name;

    public function getFor()
    {
        return $this->attributes['for']?$this->attributes['for']:null;
    }

    public function setFor($for)
    {
        $this->attributes['for'] = $for;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    protected function renderElement()
    {
        return "<label ".$this->concatAttributesToElement().">{$this->name}</label>";
    }
}
