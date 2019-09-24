<?php
namespace HomelyForm\Elements\Base;

abstract class AbstractElement
{
    protected $elementName;

    protected $attributes = [
        'class' => '',
        'id' => ''
    ];

    protected $container;

    abstract public function renderElement() : string;

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }

    public function getElementName()
    {
        return $this->elementName;
    }

    public function setElementName($elementName)
    {
        $this->elementName = $elementName;
    }

    public function getId()
    {
        return $this->attributes['id']?$this->attributes['id']:null;
    }

    public function setId($id)
    {
        $this->attributes['id'] = $id;

        return $this;
    }

    public function getClass()
    {
        return $this->attributes['class']?$this->attributes['class']:null;
    }

    public function setClass($class)
    {
        $this->attributes['class'] = $class;

        return $this;
    }

    public function appendClass($class)
    {
        $class = trim($class);

        if (strpos($this->attributes['class'], $class) === false) {
            $this->attributes['class'] .= " ".$class;
        }

        return $this;
    }

    public function removeClass($class)
    {
        if (strpos($this->attributes['class'], $class) !== false) {
            $this->attributes['class'] = trim(str_replace($class, "", $this->attributes['class']));
        }

        return $this;
    }

    public function addAttribute($attr, $value)
    {
        $this->attributes[$attr] = $value;

        return $this;
    }

    public function removeAttribute($attr)
    {
        if (isset($this->attributes[$attr])) {
            unset($this->attributes[$attr]);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->renderElement();
    }

    protected function concatAttributesToElement()
    {
        $input = '';

        foreach ($this->attributes as $attr => $value) {
            $value = trim($value);

            if ($value) {
                $input .= "{$attr}='{$value}' ";
            }
        }

        return trim($input);
    }
}
