<?php
namespace HomelyForm\Elements\Base;

use HomelyForm\Elements\Label;
use HomelyForm\Elements\Validators\ValidatorInterface;
use HomelyForm\Exceptions\HomelyFormValidatorException;
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

    protected $respectValidators = [];

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
        return isset($this->attributes['value'])&&$this->attributes['value']?$this->attributes['value']:'';
    }

    public function setValue($value)
    {
        $this->attributes['value'] = $value;

        return $this;
    }

    public function setValueFromPost($value)
    {
        return $this->setValue($value);
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

    public function addRespectValidator($validator, $options = [], $message = '')
    {
        $this->respectValidators[$validator] = [
            'options' => $options,
            'message' => $message
        ];

        return $this;
    }

    public function addCustomValidator(ValidatorInterface $validator)
    {
        $validatorName = $validator->getName()?$validator->getName():get_class($validator);

        $this->validators[$validatorName] = $validator;

        return $this;
    }

    public function isValid()
    {
        $this->errors = [];

        $valid = true;

        foreach ($this->respectValidators as $validator => $options) {
            try {
                Validator::buildRule($validator, $options['options'])->assert($this->getValue());
            } catch (ValidationException $e) {
                $this->errors[$validator] = $options['message']?$options['message']:$e->getMessage();

                $valid = false;
            }
        }

        /**
         * @var string $validatorName
         * @var ValidatorInterface $validator
         */
        foreach ($this->validators as $validatorName => $validator) {
            try {
                $validator->assert($this->getValue());
            } catch (HomelyFormValidatorException $e) {
                $this->errors[$validatorName] = $e->getMessage();

                $valid = false;
            }
        }

        return $valid;
    }

    public function showValue()
    {
        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function render()
    {
        $type = strtolower(substr(get_called_class(), strrpos(get_called_class(), '\\') + 1));

        if ($this->template != null && $this->container == null) {
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
        $errors = '';

        if ($this->label) {
            if (isset($this->template->{'labelClass'})) {
                $this->label->appendClass($this->template->{'labelClass'});
            }

            if (isset($this->template->{'labelContainer'})) {
                $this->label->setContainer($this->template->{'labelContainer'});
            }

            $label = $this->label->renderElement(). "\n";
        }

        if (sizeof($this->errors)) {
            $errorClass = '';
            $errorContainer = '<span {{errorClass}}>{{error}}</span>';

            if (isset($this->template->{$type . 'ErrorClass'})) {
                $errorClass = $this->template->{$type . 'ErrorClass'};
            } elseif (isset($this->template->{'basicErrorClass'})) {
                $errorClass = $this->template->{'basicErrorClass'};
            }

            if (isset($this->template->{$type . 'ErrorContainer'})) {
                $errorContainer = $this->template->{$type . 'ErrorContainer'};
            } elseif (isset($this->template->{'basicErrorContainer'})) {
                $errorContainer = $this->template->{'basicErrorContainer'};
            }

            foreach ($this->errors as $error) {
                $errorContainer = str_replace('{{errorClass}}', "class='{$errorClass}'", $errorContainer);
                $errors .= str_replace('{{error}}', $error, $errorContainer);
            }

            if (isset($this->template->{$type . 'ErrorContainerInput'})) {
                $this->container = $this->template->{$type . 'ErrorContainerInput'};
            } elseif (isset($this->template->{'basicContainerErrorInput'})) {
                $this->container = $this->template->{'basicContainerErrorInput'};
            }

            if (isset($this->template->{$type . 'ClassErrorInput'})) {
                $this->setClass($this->template->{$type . 'ClassErrorInput'});
            } elseif (isset($this->template->{'basicClassErrorInput'})) {
                $this->setClass($this->template->{'basicClassErrorInput'});
            }
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
                $container = str_replace('{{errors}}', $errors, $container);
            }

            return $container;
        }

        $element = $label;
        $element .= $mainElement;
        $element .= $errors;

        return $element;
    }

    public function __toString()
    {
        return $this->render();
    }
}
