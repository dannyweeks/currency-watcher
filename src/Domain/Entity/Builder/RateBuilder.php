<?php

namespace Weeks\CurrencyWatcher\Domain\Entity\Builder;

use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;

class RateBuilder
{
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
     * @return Rate
     *
     * @throws \Exception
     */
    public function build()
    {
        if (!$this->baseCurrency instanceof Currency) {
            throw new \Exception('Must set a base currency');
        }

        if (!$this->targetCurrency instanceof Currency) {
            throw new \Exception('Must set a target currency');
        }

        if (!$this->quotedAt instanceof \DateTime) {
            throw new \Exception('Must set a quoted at date/time');
        }

        if (!is_numeric($this->value)) {
            throw new \Exception('Value must be numeric');
        }

        return new Rate(
            $this->baseCurrency,
            $this->targetCurrency,
            $this->quotedAt,
            $this->applyTransactionFee($this->value)
        );
    }

    /**
     * @param \DateTime $quotedAt
     *
     * @return RateBuilder
     */
    public function setQuotedAt($quotedAt)
    {
        $this->quotedAt = $quotedAt;

        return $this;
    }

    /**
     * @param float $value
     *
     * @return RateBuilder
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @param Currency $baseCurrency
     *
     * @return RateBuilder
     */
    public function setBaseCurrency($baseCurrency)
    {
        $this->baseCurrency = $baseCurrency;

        return $this;
    }

    /**
     * @param Currency $targetCurrency
     *
     * @return RateBuilder
     */
    public function setTargetCurrency($targetCurrency)
    {
        $this->targetCurrency = $targetCurrency;

        return $this;
    }

    /**
     * @param $value
     *
     * @return float
     */
    protected function applyTransactionFee($value)
    {
        return number_format($value * 0.9725, 4);
    }
}