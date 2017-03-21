<?php
namespace MyForm\Templates;

class BootstrapTemplate implements TemplateInterface
{
    public $basicInput = '<div class="form-group">{{elementForm}}</div>';
    public $basicClassInput = 'form-control';

    public function getTextTemplate()
    {
        return $this->basicInput;
    }

    public function getEmailTemplate()
    {
        return $this->basicInput;
    }

    public function getNumberTemplate()
    {
        return $this->basicInput;
    }

    public function getPasswordTemplate()
    {
        return $this->basicInput;
    }

    public function getClassTextTemplate()
    {
        return $this->basicClassInput;
    }

    public function getClassEmailTemplate()
    {
        return $this->basicClassInput;
    }

    public function getClassNumberTemplate()
    {
        return $this->basicClassInput;
    }

    public function getClassPasswordTemplate()
    {
        return $this->basicClassInput;
    }

    public function getSelectTemplate()
    {
        return $this->basicInput;
    }

    public function getClassSelectTemplate()
    {
        return $this->basicClassInput;
    }
}
