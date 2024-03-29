<?php


namespace User\Listener;


use Core\Stdlib\CurrentUrl;
use User\Controller\IndexController;
use User\Mail\Mail;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceManager;


class SendRegisterListener extends AbstractListenerAggregate
{
        use CurrentUrl;
        private  $serviceManager;

        public function __construct(ServiceManager $serviceManager)
        {
            $this->serviceManager = $serviceManager;
        }

    /**
     * {@inheritDoc}
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {

        $sharedEvent = $events->getSharedManager();
        $this->listeners[] = $sharedEvent->attach(IndexController::class,
            'registerAction.post',
            [$this, 'onSendRegister'],
            $priority);

    }

    public function onSendRegister(Event $event)
    {
        /**
         * @var $cotroller IndexController
         * @var $user \User\Model\User
         * @var $transport \Zend\Mail\Transport\Smtp
         */

        $controller = $event->getTarget();
        $user = $event->getParams()['data'];

        $transport = $this->serviceManager->get('core.transoprt.smtp');
        $view = $this->serviceManager->get('view');

        $data = $user->getArrayCopy();
        $data['ip'] = $controller->getRequest()->getServer('REMOTE_ADDR');
        $data['host'] = $this->getUrl($controller->getRequest());

        $mail= new Mail($transport, $view, 'user/mail/register');
        $mail->setSubject('Cadastro help Desk')
            ->setTo(strtolower(trim($user->email)))
            ->setData($data)
            ->prepare()
            ->send();
    }
}
