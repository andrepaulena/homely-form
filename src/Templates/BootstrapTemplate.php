<?php
namespace HomelyForm\Templates;

use HomelyForm\Elements\Text;

class BootstrapTemplate implements TemplateInterface
{
    public static function getElementContainer(string $elemClass): array
    {
        $elements = [
            Text::class => [
                'container' => '<div class="form-group">{{label}}{{elementForm}}{{errors}}</div>',
                'inputClass' => 'text',
                'errorContainer' => '<p class="text-error">{{error}}</p>'
            ]
        ];

        if (isset($elements[$elemClass])) {
            return $elements[$elemClass];
        }

        return [
            'container' => '<div class="form-group">{{label}}{{elementForm}}{{errors}}</div>',
            'inputClass' => 'form-control',
            'errorContainer' => '<p class="error">{{error}}</p>'
        ];
    }
}
