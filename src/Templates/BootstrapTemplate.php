<?php
namespace HomelyForm\Templates;

class BootstrapTemplate
{
    public $basicContainerInput = '<div class="form-group">{{label}}{{elementForm}}{{errors}}</div>';
    public $basicClassInput = 'form-control';

    public $basicErrorClass = 'error';
    public $basicErrorContainer = '<p>{{error}}</p>';

    public $textContainer = '<div class="form-group">{{label}}{{elementForm}}{{errors}}</div>';
    public $textClass = 'form-control text';

    public $textErrorClass = 'error';
    public $textErrorContainer = '<p {{errorClass}}>{{error}}</p>';
}
