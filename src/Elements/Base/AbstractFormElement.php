<?php
namespace HomelyForm\Elements\Base;

use HomelyForm\Elements\Label;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Validator;

abstract class AbstractFormElement extends AbstractElement
{
    protected $container = '<div>{{label}}{{elementForm}}{{errors}}</div>';

    protected $errorContainer = '<span>{{error}}</span>';

    /** @var Label */
    protected $label;

    protected $validators = [];

    protected $errors = [];

    public function __construct($name, $attributes = [])
    {
        $this->label = new Label(ucfirst(strtolower($name)));

        $this->elementName = $name;
        $this->setName($name);

        return $this;
    }

    public function getName()
    {
        return $this->attributes['name']?$this->attributes['name']:null;
    }

    public function setName($name)
    {
        $this->attributes['name'] = $name;

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

    public function setLabel(Label $label)
    {
        $this->label = $label;

        return $this;
    }

    public function getValue()
    {
        if (empty($this->attributes['value']) && !empty($_POST[$this->getName()])) {
            $this->setValue($_POST[$this->getName()]);
        }

        return isset($this->attributes['value'])&&$this->attributes['value']?$this->attributes['value']:'';
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

    public function addValidator(string $validator, $options = [], $message = '')
    {
        $this->validators[$validator] = [
            'options' => $options,
            'message' => $message
        ];

        return $this;
    }

    public function isValid()
    {
        $this->errors = [];

        $valid = true;

        foreach ($this->validators as $validator => $options) {
            try {
                Validator::buildRule($validator, $options['options'])->assert($this->getValue());
            } catch (ValidationException $e) {
                $this->errors[$validator] = $options['message']?$options['message']:$e->getMessage();

                $valid = false;
            }
        }

        return $valid;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function renderElement() : string
    {
        $container = $this->container;
        $mainElement = $this->renderFormElement();
        $label = $this->label->renderElement();
        $errors = '';

        foreach ($this->errors as $error) {
            $errors .= str_replace('{{error}}', $error, $this->errorContainer);
        }

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

    /**
     * @return string
     */
    public function getErrorContainer(): string
    {
        return $this->errorContainer;
    }

    /**
     * @param string $errorContainer
     */
    public function setErrorContainer(string $errorContainer): void
    {
        $this->errorContainer = $errorContainer;
    }

    abstract protected function renderFormElement() : string;
}
