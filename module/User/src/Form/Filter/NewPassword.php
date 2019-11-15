<?php

namespace User\Form\Filter;

use Zend\Form\Element\Email;
use Zend\Form\Form;
use Zend\Validator\Csrf;

class NewPassword extends Form
{
    public function __construct($name = null, $options = [])
    {
        parent::__construct('new-password', []);

        $this->setInputFilter(new NewPasswordFilter());
        $this->setAttribute('method', 'POST');

        $email = new Email('email');
        $email->setAttributes([
            'placeholder' => 'Email',
            'class' => 'form-control',
            'maxlength' => 255]);
        $this->add($email);

        $csrf = new Csrf('csrf');
        $csrf->setOptions([
            'csrf_options' => [
                'timecut' => 600
            ]
        ]);

        $this->add($csrf);
    }
}
