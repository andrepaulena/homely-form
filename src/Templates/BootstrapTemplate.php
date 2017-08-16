<?php
namespace HomelyForm\Templates;

class BootstrapTemplate
{
    public $basicContainerInput = '<div class="form-group">{{label}}{{elementForm}}{{errors}}</div>';
    public $basicClassInput = 'form-control';

    public $textContainer = '<div class="form-group">{{label}}{{elementForm}}{{errors}}</div>';
    public $textClass = 'form-control text';
}
