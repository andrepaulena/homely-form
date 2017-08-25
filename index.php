<?php
require 'vendor/autoload.php';

class someValidator implements \HomelyForm\Elements\Validators\ValidatorInterface{
    protected $input;

    public function assert($input)
    {
        if($input == 2){
            return true;
        }

        throw new \HomelyForm\Exceptions\HomelyFormValidatorException("O valor não é igual a 2");
    }

    public function getName()
    {
        return "equal2";
    }

    public function isValid($input)
    {
        if($input == 2){
            return true;
        }

        return false;
    }
}

class FormTest extends \HomelyForm\HomelyForm
{
    public function init()
    {
        $this->setClass('form');
        $this->setMethod('post');
        $this->setAction('/');
        $this->setId('form-id');
        $this->setTemplate(HomelyForm\Templates\BootstrapTemplate::class);
    }

    public function fields()
    {
        $text = new \HomelyForm\Elements\Text('name');
        $text->setLabelName('Nome')
            ->setId('name')
            ->setClass('input-class')
            ->setPlaceHolder('Seu nome')
            ->setValue('André')
            ->addCustomValidator(new SomeValidator());

        $mail = new \HomelyForm\Elements\Email('email');
        $mail->setPlaceHolder('Seu e-mail');

        $pass = new \HomelyForm\Elements\Password('password');
        $pass->setLabelName('Senha')->setPlaceHolder('Sua senha');

        $file = new \HomelyForm\Elements\File('file');
        $file->setLabelName('Arquivo');

        $select = new \HomelyForm\Elements\Select('select');
        $select->setLabelName('Coisa')->setOptions(['nope'=>'hehe','hehe'=>'nope']);

        $check = new \HomelyForm\Elements\CheckBox('check');
        $check->setLabelName('Test check');

        $radio = new \HomelyForm\Elements\Radio('radio1');
        $radio->setLabelName('Test radio 1')->setName('radio')->setValue('primeiro');

        $radio2 = new \HomelyForm\Elements\Radio('radio2');
        $radio2->setLabelName('Test radio 2')->setName('radio2')->setValue('segundo');

        $textArea = new \HomelyForm\Elements\TextArea('textArea');
        $textArea->setLabelName('Text Area hehe');

        $submit = new \HomelyForm\Elements\Button('submit');
        $submit->setName('Enviar')->setType('submit');

        return get_defined_vars();
    }
}

try{

    $form = new FormTest();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $form->isValid();

        var_dump($form->getPost());
    }

    echo $form;

}catch (Throwable $e){
    var_dump($e);
}