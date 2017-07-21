<?php

namespace Weeks\CurrencyWatcher\Domain\Mailer;

use Weeks\CurrencyWatcher\Domain\Entity\Message;

interface MailerInterface
{
    /**
     * @param Message $message
     *
     * @return boolean
     */
    public function send(Message $message);
}