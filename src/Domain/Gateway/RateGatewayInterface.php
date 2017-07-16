<?php

namespace Weeks\CurrencyWatcher\Domain\Gateway;

use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;

interface RateGatewayInterface
{
    /**
     * @param Currency $baseCurrency
     * @param Currency $targetCurrency
     *
     * @return Rate
     */
    public function getCurrentRate(Currency $baseCurrency, Currency $targetCurrency);
}