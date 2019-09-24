<?php
namespace HomelyForm;

use HomelyForm\Elements\Base\AbstractElement;
use HomelyForm\Elements\Base\AbstractFormElement;
use HomelyForm\Exceptions\HomelyFormException;
use HomelyForm\Templates\TemplateInterface;

abstract class HomelyForm extends AbstractElement
{
    protected $attributes = [
        'method' => 'POST',
        'action' => '/'
    ];

    protected $elements = [];

    protected $values = [];

    /** @var TemplateInterface */
    protected $template;

    abstract public function fields() : array;

    public function __construct()
    {
        $fields = $this->fields();

        if (is_array($fields) && !empty($fields)) {
            foreach ($fields as $field) {
                $this->add($field);
            }
        }
    }

    public function renderElement() : string
    {
        $form = "<form ".$this->concatAttributesToElement().">\n";

        /** @var AbstractFormElement $element */
        foreach ($this->elements as $element) {
            $form .= $element->renderElement()."\n";
        }

        $form .= "</form>";

        return $form;
    }

    public function add(AbstractElement $element)
    {
        if ($element instanceof AbstractFormElement && $this->template) {
            $container = $this->template::getElementContainer(get_class($element));

            $element->setContainer($container['container']);
            $element->appendClass($container['inputClass']);
            $element->setErrorContainer($container['errorContainer']);
        }

        $this->elements[$element->getElementName()] = $element;

        return $this;
    }

    public function getElement(string $name) : AbstractFormElement
    {
        if (isset($this->elements[$name])) {
            return $this->elements[$name];
        }

        throw new HomelyFormException('Element [' . $name . '] not found');
    }

    public function removeElement($name)
    {
        if (isset($this->elements[$name])) {
            unset($this->elements[$name]);
            return true;
        }

        throw new HomelyFormException('Element [' . $name . '] not found');
        ;
    }

    public function getAction() : string
    {
        return $this->attributes['action'];
    }

    public function setAction(string $action)
    {
        $this->attributes['action'] = $action;

        return $this;
    }

    public function getMethod() : string
    {
        return $this->attributes['method']?$this->attributes['method']:null;
    }

    public function setMethod(string $method)
    {
        $this->attributes['method'] = $method;
        return $this;
    }

    public function setValues($values = [])
    {
        foreach ($values as $key => $value) {
            /** @var AbstractFormElement $element */
            foreach ($this->elements as $element) {
                if ($key == $element->getName()) {
                    $element->setValue($value);
                }
            }
        }
    }

    public function isValid()
    {
        $this->getValues();

        $valid = true;

        /** @var AbstractFormElement $field */
        foreach ($this->elements as &$field) {
            if ($field instanceof AbstractFormElement && !$field->isValid() && $valid) {
                $valid = false;
            }
        }

        return $valid;
    }

    public function getErrors()
    {
        $errors = [];

        /** @var AbstractFormElement $field */
        foreach ($this->elements as $field) {
            if ($field instanceof AbstractFormElement) {
                $error = $field->getErrors();

                if (sizeof($error)) {
                    $errors[$field->getElementName()] = $error;
                }
            }
        }

        return $errors;
    }

    public function getValues()
    {
        if (!empty($this->values)) {
            return $this->values;
        }

        /** @var AbstractFormElement $element */
        foreach ($this->elements as $element) {
            if ($element instanceof AbstractFormElement) {
                $this->values[$element->getElementName()] = $element->getValue();
            }
        }

        return $this->values;
    }
}
