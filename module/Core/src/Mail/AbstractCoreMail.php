<?php


namespace Core\Mail;
use Zend\View\View;
use Zend\Mail\Message;
use Zend\Mime\Part as MimePart;
use Zend\Mime\Message as MimeMessage;
use Zend\Mail\Transport\Smtp as SmtTransport;


Abstract class AbstractCoreMail
{
    protected $transport;
    protected $view;
    protected $body;
    protected $message;
    protected $subject;
    protected $to;
    protected $replayTo;
    protected $data;
    protected $page;
    protected $cc;

    public function __construct(SmtTransport $transport, View $view, $page)
    {
        $this->transport = $transport;
        $this->view = $view;
        $this->page = $page;
    }



    /**
     * @param mixed $view
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }


    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }



    /**
     * @param mixed $to
     */
    public function setTo($to)
    {
        $this->to = $to;

        return $this;
    }


    /**
     * @param mixed $replayTo
     */
    public function setReplayTo($replayTo)
    {
        $this->replayTo = $replayTo;

        return $this;
    }



    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }


    /**
     * @param mixed $page
     */
    public function setPage($page)
    {
        $this->page = $page;

        return $this;
    }



    /**
     * @param mixed $cc
     */
    public function setCc($cc)
    {
        $this->cc = $cc;

        return $this;
    }



    /**
     * @param mixed $transport
     */
    public function setTransport($transport)
    {
        $this->transport = $transport;

        return $this;
    }

    abstract public function renderView($page, array $data);


    public function prepare()
    {
        $html = new MimePart($this->renderView($this->page, $this->data));
        $html->type = 'text/html';

        $body = new MimeMessage();
        $body->setParts([$html]);
        $this->body = $body;

        $configg = $this->transport->getOptions()->toArray();

        $this->message = new Message();
        $this->message->addFrom($configg['connection_config']['connection_config'])
            ->addTo($this->to)
            ->setSubject($this->subject)
            ->setBody($this->body);

        if ($this->cc){
            $this->message->addCc($this->cc);
        }

        if($this->replayTo){
            $this->message->addCc($this->replayTo);
        }

        return $this;
    }

    public function send(){
        $this->transport->send($this->message);
    }


}
