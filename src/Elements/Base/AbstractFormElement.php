<?php
namespace HomelyForm\Elements\Base;

use HomelyForm\Elements\Label;

abstract class AbstractFormElement extends AbstractElement
{
    public function __construct($title)
    {
        $this->label = new Label($title);
        $this->elementName = $title;
        $this->name = $title;
    }

    protected $placeHolder;

    protected $name;

    protected $label;

    protected $value;

    protected $required = false;

    protected $disabled = false;

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        $this->toAddInElement['name'] = $this->id;

        return $this;
    }

    public function setLabelName($name)
    {
        $this->label->setName($name);

        return $this;
    }

    public function setId($id)
    {
        parent::setId($id);
        $this->label->setFor($this->id);

        return $this;
    }

    public function getPlaceHolder()
    {
        return $this->placeHolder;
    }

    public function setPlaceHolder($placeHolder)
    {
        $this->placeHolder = $placeHolder;
        $this->toAddInElement['placeholder'] = $this->placeHolder;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = null;

        if ($label instanceof Label) {
            $this->label = $label;
        }

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
        $this->toAddInElement['value'] = $value;

        return $this;
    }

    public function setRequired($required = true)
    {
        $this->required = $required;
        $this->toAddInElement['required'] = $this->required;

        return $this;
    }

    public function setDisabled($disabled = true)
    {
        $this->disabled = $disabled;
        $this->toAddInElement['disabled'] = $this->disabled;

        return $this;
    }

    public function render()
    {
        if ($this->container == null && $this->template != null) {
            $class = substr(get_called_class(), strrpos(get_called_class(), '\\')+1);
            $containerMethod = "get{$class}Template";
            $classMethod = "getClass{$class}Template";

            if (method_exists($this->template, $containerMethod)) {
                $this->container = $this->template->{$containerMethod}();
            }

            if (method_exists($this->template, $classMethod)) {
                $this->appendClass($this->template->{$classMethod}());
            }
        }

        $element = '';

        if ($this->label) {
            $element .= $this->label->renderElement()."\n";
        }

        $element .= $this->renderElement();

        if ($this->container) {
            if (strpos($this->container, '{{elementForm}}') !== false) {
                $element = str_replace('{{elementForm}}', $element, $this->container);
            }
        }

        return $element;
    }

    public function __toString()
    {
        return $this->render();
    }
}
