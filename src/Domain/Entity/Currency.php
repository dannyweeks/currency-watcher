<?php

namespace Weeks\CurrencyWatcher\Domain\Entity;

use Weeks\CurrencyWatcher\Domain\Entity\Traits\IdentifiableTrait;

class Currency implements \JsonSerializable
{
    use IdentifiableTrait;

    const CODE_GBP = 'GBP';
    const CODE_ISK = 'ISK';

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

    /**
     * Specify data which should be serialized to JSON
     * @link  http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'code'        => $this->getCode(),
            'countryName' => $this->getCountryName(),
        ];
    }
}