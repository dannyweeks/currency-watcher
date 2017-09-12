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
     * @param Currency $baseCurrency
     * @param Currency $targetCurrency
     *
     * @return Rate
     */
    public function lastRate(Currency $baseCurrency, Currency $targetCurrency);

    /**
     * @param Rate $rate
     *
     * @return Rate
     */
    public function save(Rate $rate);

    /**
     * @param integer  $limit
     * @param integer  $offset
     * @param Currency $base
     * @param Currency $target
     * @param string   $orderBy
     * @param string   $orderDirection
     *
     * @return Rate[]
     */
    public function search($limit, $offset, Currency $base, Currency $target, $orderBy = '', $orderDirection = 'DESC');
}