<?php


namespace User\Form;

use User\Form\Filter\UserFilter;
use Zend\Form\Element\Email;
use Zend\Form\Element\Password;
use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\Db\Adapter\Adapter;
use Zend\Validator\Csrf;


class UserForm extends Form
{
    public function __construct(Adapter $adapter)
    {
        parent::__construct('user', []);

        $this->setInputFilter(new UserFilter($adapter));
        $this->setAttributes(['method' => 'POST']);

        $name = new Text('name');
        $name->setAttributes([
            'placeholder' => 'Full name',
            'class' => 'form-control',
            'maxlength' => 120
        ]);
        $this->add($name);

        $email = new Email('email');
        $email->setAttributes([
            'placeholder' => 'Email',
            'class' => 'form-control',
            'maxlength' => 255
        ]);
        $this->add($email);

        $password = new Password('password');
        $password->setAttributes([
            'placeholder' => 'Password',
            'class' => 'form-control',
            'maxlength' => 48
        ]);
        $this->add($password);

        $verifyPassword = new Password('verifypassword');
        $verifyPassword->setAttributes([
            'placeholder' => 'Retype Password',
            'class' => 'form-control',
            'maxlength' => 48
        ]);
        $this->add($verifyPassword);

        $csrf = new Csrf('csrf');

        $csrf->setOptions([
           'csrf_options' => [
               'timeout' => 600
           ]
        ]);
        $this->add($csrf);
    }

}
