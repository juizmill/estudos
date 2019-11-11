<?php


namespace User\Form\Filter;

use Zend\InputFilter\InputFilter;
use Zend\Validator\StringLength;



class NewPasswordFilter extends inputFIlter
{
    public function __construct()
    {

        $email = new Input('email');
        $email->setRequired(true)
            ->getFilterChain()->attachByName('stringtrim')->attachByName('stripTags');
        $email->getValidatorChain()->addValidator(new notEmpty())
            ->addVaklidator(new StringLength(['max' => 255]));
        $this->add($email);

    }


}
