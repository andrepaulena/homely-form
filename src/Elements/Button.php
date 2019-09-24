<?php
namespace HomelyForm\Elements;

use HomelyForm\Elements\Base\AbstractElement;

class Button extends AbstractElement
{
    protected $name;

    protected $container = '<div>{{element}}</div>';

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->elementName =  str_replace(' ', '-', mb_strtolower(trim($name)));
    }

    public function renderElement() : string
    {
        return "<button {$this->concatAttributesToElement()}>{$this->name}</button>";
    }

    public function setType(string $type)
    {
        $this->attributes['type'] = $type;

        return $this;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }
}
