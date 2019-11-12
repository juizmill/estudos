<?php


namespace User\Listener;


use Core\Stdlib\CurrentUrl;
use User\Controller\IndexController;
use User\Mail\Mail;
use User\Model\UserTable;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\Event;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceManager;
use Exception;


class SendRecoverPasswordListener extends AbstractListenerAggregate
{
    use CurrentUrl;
    private $serviceManager;

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
            'recoveredPasswordAction.post',
            [$this, 'onSendRegister'],
            $priority);

    }

    public function onSendRegister(Event $event)
    {
        /**
         * @var $cotroller IndexController
         * @var $user \User\Model\User
         * @var $transport \Zend\Mail\Transport\Smtp
         * @var $userTable \User\Model\UserTable
         */

        $controller = $event->getTarget();
        $email = $event->getParams()['data'];

        try {
            $userTable = $this->serviceManager->get(UserTable::class);
            $user = $userTable->getUserByEmail($email);

            $user = $userTable->save([
                'id' => $user->id,
                'email' => $user->email
            ]);

            $transport = $this->serviceManager->get('core.transoprt.smtp');
            $view = $this->serviceManager->get('view');

            $data = $user->getArrayCopy();
            $data['ip'] = $controller->getRequest()->getServer('REMOTE_ADDR');
            $data['host'] = $this->getUrl($controller->getRequest());

            $mail = new Mail($transport, $view, 'user/mail/recover-password');
            $mail->setSubject('Nova senha')
                ->setTo(strtolower(trim($user->email)))
                ->setData($data)
                ->prepare()
                ->send();

        } catch (Exception $exception) {
            echo $exception->getTraceAsString();
            die;
        }
    }
}
