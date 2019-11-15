<?php


namespace User\Form\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Db\Adapter\Adapter;
use Zend\Validator\Db\NoRecordExists;
use Zend\Validator\Identical;
use Zend\Validator\NotEmpty;
use Zend\Validator\StringLength;
use Zend\InputFilter\Input;

class UserFilter extends inputFIlter
{
    public function __construct(Adapter $adapter)
    {
        $name = new Input('name');
        $name->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('stripTags');
        $name->getValidatorChain()->addValidator(new notEmpty())
            ->addValidator(new StringLength(['max' => 120]));
        $this->add($name);


        $email = new Input('email');
        $email->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('stripTags');
        $email->getValidatorChain()->addValidator(new notEmpty())
            ->addValidator(new StringLength(['max' => 255]))
            ->addValidator(new NoRecordExists([
                'table' => 'users',
                'field' => 'email',
                'adapter' => $adapter,
                'mensagens' => [
                    'recordFound' => 'Este E-MAIL já esta em uso'
                ]
            ]));
        $this->add($email);


        $password = new Input('password');
        $password->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('stripTags');
        $password->getValidatorChain()->addValidator(new notEmpty())
            ->addValidator(new StringLength(['max' => 48, 'min' => 5]))
            ->addValidator(new Identical([
                'token' => 'verifypassword',
                'mensagens' => [
                    'recordFound' => 'As senhas fornecidas não combinam'
                ]
            ]));
        $this->add($password);

        $verifyPassword = new Input('verifypassword');
        $verifyPassword->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('stripTags');
        $verifyPassword->getValidatorChain()->addValidator(new notEmpty())
            ->addValidator(new StringLength(['max' => 48, 'min' => 5]));
        $this->add($verifyPassword);
    }
}
