<?php
namespace MyForm\Elements;

use MyForm\Elements\Base\AbstractElement;

class Label extends AbstractElement
{
    public function __construct($name)
    {
        $this->name = $name;
    }

    protected $for;

    protected $name;

    public function getFor()
    {
        return $this->for;
    }

    public function setFor($for)
    {
        $this->for = $for;
        $this->toAddInElement['for'] = $this->for;
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
        return "<label ".$this->prepareElement().">{$this->name}</label>";
    }
}
