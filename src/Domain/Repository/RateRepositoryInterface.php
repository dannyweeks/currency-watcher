<?php

namespace Weeks\CurrencyWatcher\Domain\Repository;

use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;

interface RateRepositoryInterface
{
    /**
     * @param Currency $baseCurrency
     * @param Currency $targetCurrency
     *
     * @return Rate
     */
    public function getLatestRate(Currency $baseCurrency, Currency $targetCurrency);

    /**
     * @param Rate $rate
     *
     * @return Rate
     */
    public function save(Rate $rate);
}