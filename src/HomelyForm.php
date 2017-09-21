<?php
namespace HomelyForm;

use HomelyForm\Elements\Base\AbstractElement;
use HomelyForm\Elements\Base\AbstractFormElement;

class HomelyForm extends AbstractElement
{
    protected $elements = [];

    protected $fromPost = [];
    
    public function __construct()
    {
        $this->addAttribute('method', 'POST');
        $this->addAttribute('action', '/');

        $this->init();

        $fields = $this->fields();

        if (is_array($fields) && !empty($fields)) {
            foreach ($fields as $field) {
                $this->add($field);
            }
        }
    }

    public function init()
    {
    }

    protected function renderElement()
    {
        $form = "<form ".$this->concatAttributesToElement().">\n";

        /** @var AbstractFormElement $element */
        foreach ($this->elements as $element) {
            $form .= $element->render()."\n";
        }

        $form .= "</form>";

        return $form;
    }

    public function add(AbstractFormElement $element)
    {
        $this->elements[$element->getElementName()] = $element;

        if ($element->getContainer() == null && $this->template != null) {
            $element->setTemplate($this->template);
        }

        return $this;
    }

    public function getElementById($id)
    {
        /** @var AbstractFormElement $element */
        foreach ($this->elements as $element) {
            if ($element->getId() == $id) {
                return $element;
            }
        }

        return null;
    }

    public function getElementByName($name)
    {
        /** @var AbstractFormElement $element */
        foreach ($this->elements as $element) {
            if ($element->getName() == $name) {
                return $element;
            }
        }

        return null;
    }

    public function getElement($name)
    {
        if (isset($this->elements[$name])) {
            return $this->elements[$name];
        }

        return null;
    }

    public function removeElement($name)
    {
        if (isset($this->elements[$name])) {
            unset($this->elements[$name]);
            return true;
        }

        return false;
    }

    public function getAction()
    {
        return $this->attributes['method']?$this->attributes['method']:null;
    }

    public function setAction($action)
    {
        $this->attributes['action'] = $action;

        return $this;
    }

    public function getMethod()
    {
        return $this->attributes['method']?$this->attributes['method']:null;
    }

    public function setMethod($method)
    {
        $this->attributes['method'] = $method;
        return $this;
    }

    public function fields()
    {
        return [];
    }

    public function getPost()
    {
        if (empty($this->fromPost)) {
            /** @var AbstractFormElement $element */
            foreach ($this->elements as &$element) {
                if (isset($_POST[$element->getName()])) {
                    $element->setValueFromPost($_POST[$element->getName()]);
                    $this->fromPost[$element->getName()] = $_POST[$element->getName()];
                } elseif ($element->showValue()) {
                    $this->fromPost[$element->getName()] = '';
                }
            }
        }

        return $this->fromPost;
    }

    public function setValues($values)
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
        $this->getPost();

        $valid = true;

        /** @var AbstractFormElement $field */
        foreach ($this->elements as &$field) {
            if (!$field->isValid() && $valid) {
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
            $error = $field->getErrors();

            if (sizeof($error)) {
                $errors[$field->getElementName()] = $error;
            }
        }

        return $errors;
    }

    public function getValues()
    {
        $values = [];

        /** @var AbstractFormElement $element */
        foreach ($this->elements as $element) {
            if ($element->showValue()) {
                $values[$element->getElementName()] = $element->getValue();
            }
        }

        return $values;
    }
}
