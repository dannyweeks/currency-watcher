<?php

namespace Weeks\CurrencyWatcher\Domain\Repository;

use Weeks\CurrencyWatcher\Domain\Entity\Currency;

interface CurrencyRepositoryInterface
{
    /**
     * @param $code
     *
     * @return Currency
     */
    public function getByCode($code);

    /**
     * @param Currency $currency
     *
     * @return Currency
     */
    public function save(Currency $currency);
}