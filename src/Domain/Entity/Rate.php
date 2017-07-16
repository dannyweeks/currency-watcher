<?php

namespace Weeks\CurrencyWatcher\Domain\Entity;

use Weeks\CurrencyWatcher\Domain\Entity\Traits\IdentifiableTrait;

class Rate
{
    use IdentifiableTrait;

    /**
     * @var \DateTime
     */
    protected $quotedAt;

    /**
     * @var float
     */
    protected $value;

    /**
     * @var Currency
     */
    protected $baseCurrency;

    /**
     * @var Currency
     */
    protected $targetCurrency;
}