<?php
namespace HomelyForm\Templates;

interface TemplateInterface
{
    public static function getElementContainer(string $elemClass): array;
}
