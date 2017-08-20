<?php
namespace HomelyForm\Elements\Base;

abstract class AbstractElement
{
    protected $template;

    protected $elementName;

    protected $attributes = [
        'id' => '',
        'class' => '',
        'style' => []
    ];

    protected $container;

    abstract protected function renderElement();

    public function setTemplate($template)
    {
        if (!is_object($template)) {
            $this->template = new $template();
        } else {
            $this->template = $template;
        }
    }

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
        if (strpos($this->attributes['class'], $class) === false) {
            $this->attributes['class'] .= " ".$class;
        }

        return $this;
    }

    public function prependClass($class)
    {
        if (strpos($this->attributes['class'], $class) === false) {
            $this->attributes['class'] = $class." ".$this->attributes['class'];
        }

        return $this;
    }

    public function removeClass($class)
    {
        if (strpos($this->attributes['class'], $class) !== false) {
            $this->attributes['class'] = str_replace($class, "", $this->attributes['class']);
        }

        return $this;
    }

    public function addStyle($attr, $value)
    {
        $this->attributes['style'][$attr] = $value;

        return $this;
    }

    public function removeStyle($attr)
    {
        if (isset($this->attributes['style'][$attr])) {
            unset($this->attributes['style'][$attr]);
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
            if ($attr == 'style') {
                if (sizeof($value)) {
                    $valueStyle = [];

                    foreach ($value as $style => &$valueStyle) {
                        $valueStyle = $style.':'.$valueStyle;
                    }

                    $valueStyle = implode(';', $value);

                    $input .= "{$attr}='{$valueStyle}' ";
                }
            } else {
                $value = trim($value);

                if ($value) {
                    $input .= "{$attr}='{$value}' ";
                }
            }
        }

        return trim($input);
    }
}
