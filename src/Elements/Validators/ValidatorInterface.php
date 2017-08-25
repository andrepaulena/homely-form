<?php
namespace HomelyForm\Elements\Validators;

interface ValidatorInterface
{
    public function assert($input);

    public function getName();

    public function isValid($input);
}
