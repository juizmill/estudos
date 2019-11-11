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
        $this ->$this->setAttribute(['method' => 'POST']);

        $name = new Text('name');
        $name->setAttribute([
            'placeholder' => 'Full name',
            'class' => 'form-control',
            'maxlength' => 120
        ]);
        $this->add($name);

        $email = new Email('email');
        $email->setAttribute([
            'placeholder' => 'Email',
            'class' => 'form-control',
            'maxlength' => 255
        ]);
        $this->add($email);

        $password = new Password('password');
        $password->setAttribute([
            'placeholder' => 'Password',
            'class' => 'form-control',
            'maxlength' => 48
        ]);
        $this->add($password);

        $verifyPassword = new Password('verifyPassword');
        $password->setAttribute([
            'placeholder' => 'Retype Password',
            'class' => 'form-control',
            'maxlength' => 48
        ]);
        $this->add($verifyPassword);

        $csrf = new Csrf('csrf');
        $csrf->setOptions([
           'csrf_options' => [
               'timecut' => 600
           ]
        ]);

        $this->add($csrf);
    }

}
