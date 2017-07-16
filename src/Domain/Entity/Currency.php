<?php

namespace Weeks\CurrencyWatcher\Domain\Entity;

use Weeks\CurrencyWatcher\Domain\Entity\Traits\IdentifiableTrait;

class Currency
{
    use IdentifiableTrait;

    /**
     * The three letter international currency code.
     *
     * @var string
     */
    protected $code;

    /**
     * HTML symbol used for this currency
     *
     * @var string
     */
    protected $symbol;

    /**
     * @var string
     */
    protected $countryName;

    /**
     * @param string $code
     * @param string $symbol
     * @param string $countryName
     */
    public function __construct($code, $symbol, $countryName)
    {
        $this->code = $code;
        $this->symbol = $symbol;
        $this->countryName = $countryName;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }
}