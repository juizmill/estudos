<?php

namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function registerAction()
    {
        $this->layout()->setTemplate('user/layout/layout');
        return new ViewModel();
    }

    public function recoveredPasswordAction()
    {
        $this->layout()->setTemplate('user/layout/layout');

        return new ViewModel();
    }

    public function newPasswordAction()
    {
        $this->layout()->setTemplate('user/layout/layout');

        return new ViewModel();
    }

    public function confirmarEmailAction()
    {
        return new ViewModel();
    }
}
