<?php
namespace MyForm\Elements\Base;

use MyForm\Templates\TemplateInterface;

abstract class AbstractElement
{
    /** @var TemplateInterface */
    protected $template;

    protected $elementName;

    protected $id;

    protected $class;

    protected $attributes = [];

    protected $style = [];

    protected $toAddInElement = [];

    protected $container;

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }

    abstract protected function renderElement();

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
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    public function getClass()
    {
        return $this->class;
    }

    public function setClass($class)
    {
        $this->class = $class;
        return $this;
    }

    public function appendClass($class)
    {
        if (strpos($this->class, $class) === false) {
            $this->class .= " ".$class;
        }

        return $this;
    }

    public function prependClass($class)
    {
        $this->class = $class." ".$this->class;

        return $this;
    }

    public function removeClass($class)
    {
        if (strpos($this->class, $class) !== false) {
            $this->class = str_replace($class, "", $this->class);
        }

        return $this;
    }

    public function addStyle($attr, $value)
    {
        $this->style[$attr] = $value;
    }

    public function removeStyle($attr)
    {
        if (isset($this->style[$attr])) {
            unset($this->style[$attr]);
        }
    }

    public function setTemplate(TemplateInterface $template)
    {
        $this->template = $template;
    }

    public function __toString()
    {
        return $this->renderElement();
    }

    protected function prepareElement()
    {
        $input = '';

        $this->toAddInElement['id'] = $this->id;
        $this->toAddInElement['class'] = $this->class;

        foreach ($this->toAddInElement as $attr => $value) {
            $value = trim($value);

            if ($value) {
                $input .= " {$attr}='{$value}' ";
            }
        }

        return $input;
    }
}
