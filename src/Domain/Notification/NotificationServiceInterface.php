<?php

namespace Weeks\CurrencyWatcher\Domain\Notification;

interface NotificationServiceInterface
{
    /**
     * @return
     */
    public function notifyOnNewRate();
}