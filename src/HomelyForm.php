<?php
namespace HomelyForm;

use MyForm\Elements\Base\AbstractElement;
use MyForm\Elements\Base\AbstractFormElement;

class HomelyForm extends AbstractElement
{
    protected $elements = [];

    protected $action = '/';

    protected $method = 'POST';

    public function __construct()
    {
        if ($this->template) {
            $this->template = new $this->template();
        }

        if (is_array($this->fields()) && !empty($this->fields())) {
            foreach ($this->fields() as $field) {
                $this->add($field);
            }
        }

        $this->appendClass($this->class);
        $this->setId($this->id);
        $this->setAction($this->action);
        $this->setMethod($this->method);
    }

    protected function renderElement()
    {
        $form = "<form ".$this->prepareElement().">\n";

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
        return $this->action;
    }

    public function setAction($action)
    {
        $this->action = $action;
        $this->toAddInElement['action'] = $this->action;

        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setMethod($method)
    {
        $this->method = $method;
        $this->toAddInElement['method'] = $this->method;
        return $this;
    }

    public function fields()
    {
        return [];
    }
}
