<?php

namespace Weeks\CurrencyWatcher\Application\Gateway;

use Swap\Swap;
use Weeks\CurrencyWatcher\Domain\Entity\Builder\RateBuilder;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;
use Weeks\CurrencyWatcher\Domain\Gateway\RateGatewayInterface;

class SwapRateGateway implements RateGatewayInterface
{
    /**
     * @var Swap
     */
    protected $swap;

    /**
     * @var RateBuilder
     */
    protected $rateBuilder;

    /**
     * SwapRateGateway constructor.
     *
     * @param Swap        $swap
     * @param RateBuilder $rateBuilder
     */
    public function __construct(Swap $swap, RateBuilder $rateBuilder)
    {
        $this->swap = $swap;
        $this->rateBuilder = $rateBuilder;
    }

    /**
     * @param Currency $baseCurrency
     * @param Currency $targetCurrency
     *
     * @return Rate
     */
    public function getCurrentRate(
        Currency $baseCurrency,
        Currency $targetCurrency
    ) {
        $exchangeRate = $this->swap->latest(
            $baseCurrency->getCode()
            . '/'
            . $targetCurrency->getCode()
        );

        return $this->rateBuilder
            ->setBaseCurrency($baseCurrency)
            ->setTargetCurrency($targetCurrency)
            ->setQuotedAt($exchangeRate->getDate())
            ->setValue($exchangeRate->getValue())
            ->build();
    }
}