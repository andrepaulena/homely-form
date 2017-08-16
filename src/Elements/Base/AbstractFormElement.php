<?php
namespace HomelyForm\Elements\Base;

use HomelyForm\Elements\Label;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator;

abstract class AbstractFormElement extends AbstractElement
{
    public function __construct($title)
    {
        $this->label = new Label($title);
        $this->label->setName(ucfirst(strtolower($title)));

        $this->elementName = $title;
        $this->setName($title);
    }

    protected $label;

    protected $validators = [];

    protected $errors = [];

    public function getName()
    {
        return $this->attributes['name']?$this->attributes['name']:null;
    }

    public function setName($name)
    {
        $this->attributes['name'] = $name;

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
        $this->label->setFor($id);

        return $this;
    }

    public function getPlaceHolder()
    {
        return $this->attributes['placeholder']?$this->attributes['placeHolder']:null;
    }

    public function setPlaceHolder($placeHolder)
    {
        $this->attributes['placeholder'] = $placeHolder;

        return $this;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        if ($label instanceof Label) {
            $this->label = $label;
        }

        return $this;
    }

    public function getValue()
    {
        return $this->attributes['placeHolder']?$this->attributes['placeHolder']:null;
    }

    public function setValue($value)
    {
        $this->attributes['value'] = $value;

        return $this;
    }

    public function setRequired($required = true)
    {
        $this->attributes['required'] = $required;

        return $this;
    }

    public function setDisabled($disabled = true)
    {
        $this->attributes['disabled'] = $disabled;

        return $this;
    }

    public function addValidator($validator, $options = [], $message = '')
    {
        $this->validators[$validator] = [
            'options' => $options,
            'message' => $message
        ];

        return $this;
    }

    public function isValid()
    {
        foreach ($this->validators as $validator => $options) {
            try {
                Validator::buildRule($validator, $options['options'])->assert($this->getValue());
            } catch (ValidationException $e) {
                $this->errors[$validator] = $options['message']?$options['message']:$e->getMessage();
            }
        }
    }

    public function render()
    {
        if ($this->template != null && $this->container == null) {
            $type = strtolower(substr(get_called_class(), strrpos(get_called_class(), '\\') + 1));

            if (isset($this->template->{$type . 'Container'})) {
                $this->container = $this->template->{$type . 'Container'};
            } elseif (isset($this->template->{'basicContainerInput'})) {
                $this->container = $this->template->{'basicContainerInput'};
            }

            if (isset($this->template->{$type . 'Class'})) {
                $this->appendClass($this->template->{$type . 'Class'});
            } elseif (isset($this->template->{'basicClassInput'})) {
                $this->appendClass($this->template->{'basicClassInput'});
            }
        }

        $label = '';
        $element = '';

        if ($this->label) {
            $label = $this->label->renderElement(). "\n";
        }

        $mainElement = $this->renderElement();
        $container = $this->container;

        if ($this->container) {
            if (strpos($container, '{{label}}') !== false) {
                $container = str_replace('{{label}}', $label, $container);
            }

            if (strpos($container, '{{elementForm}}') !== false) {
                $container = str_replace('{{elementForm}}', $mainElement, $container);
            }

            if (strpos($container, '{{errors}}') !== false) {
                $container = str_replace('{{errors}}', '', $container);
            }

            return $container;
        }

        $element = $label;
        $element .= $mainElement;

        return $element;
    }

    public function __toString()
    {
        return $this->render();
    }
}
