<?php

namespace Weeks\CurrencyWatcher\Domain\Entity;

use Weeks\CurrencyWatcher\Domain\Entity\Traits\IdentifiableTrait;

class Rate implements \JsonSerializable
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

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'quotedAt'       => $this->getQuotedAt()->format(\DATE_ISO8601),
            'value'          => $this->getValue(),
            'baseCurrency'   => $this->getBaseCurrency(),
            'targetCurrency' => $this->getTargetCurrency(),
        ];
    }
}