<?php


namespace User\Mail;


use Core\Mail\AbstractCoreMail;
use Zend\View\Model\ViewModel;

class Mail extends AbstractCoreMail
{

    public function renderView($page, array $data)
    {
        $model = new ViewModel();
        $model->setTemplate($page);
        $model->setOption('has_parent', true);
        $model->setVariables(['data' => $data]);

        return$this->view->render($model);
    }
}
