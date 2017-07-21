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

    /**
     * Rate constructor.
     *
     * @param Currency     $baseCurrency
     * @param Currency     $targetCurrency
     * @param \DateTime    $quotedAt
     * @param string|float $value
     */
    public function __construct(
        Currency $baseCurrency,
        Currency $targetCurrency,
        \DateTime $quotedAt,
        $value
    ) {
        $this->baseCurrency = $baseCurrency;
        $this->targetCurrency = $targetCurrency;
        $this->quotedAt = $quotedAt;
        $this->value = $value;
    }

    /**
     * @return \DateTime
     */
    public function getQuotedAt()
    {
        return $this->quotedAt;
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return Currency
     */
    public function getBaseCurrency()
    {
        return $this->baseCurrency;
    }

    /**
     * @return Currency
     */
    public function getTargetCurrency()
    {
        return $this->targetCurrency;
    }
}