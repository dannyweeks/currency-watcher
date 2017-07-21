<?php

namespace Weeks\CurrencyWatcher\Application\Mailer;

use Weeks\CurrencyWatcher\Domain\Entity\Message;
use Weeks\CurrencyWatcher\Domain\Mailer\MailerInterface;

class SwiftMailer implements MailerInterface
{
    /**
     * @var \Swift_Mailer
     */
    protected $swift;

    /**
     * @var string
     */
    protected $globalFrom;

    /**
     * SwiftMailer constructor.
     *
     * @param \Swift_Mailer $swift
     * @param  string       $globalFrom
     */
    public function __construct(\Swift_Mailer $swift, $globalFrom)
    {
        $this->swift = $swift;
        $this->globalFrom = $globalFrom;
    }

    /**
     * @param Message $message
     *
     * @return boolean
     */
    public function send(Message $message)
    {
        return $this->swift->send(
            $this->toSwiftMessage($message)
        );
    }

    /**
     * @param Message $message
     *
     * @return \Swift_Message
     */
    protected function toSwiftMessage(Message $message)
    {
        return (new \Swift_Message())
            ->setTo($message->getTo())
            ->setFrom($this->globalFrom)
            ->setSubject($message->getSubject())
            ->setBody($message->getBody(), 'text/html');
    }
}