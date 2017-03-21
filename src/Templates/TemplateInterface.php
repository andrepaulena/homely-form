<?php
namespace HomelyForm\Templates;

interface TemplateInterface
{
    public function getTextTemplate();

    public function getEmailTemplate();

    public function getNumberTemplate();

    public function getPasswordTemplate();

    public function getSelectTemplate();

    public function getClassTextTemplate();

    public function getClassEmailTemplate();

    public function getClassNumberTemplate();

    public function getClassPasswordTemplate();

    public function getClassSelectTemplate();
}
