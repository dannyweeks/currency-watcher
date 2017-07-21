<?php

namespace Weeks\CurrencyWatcher\Domain\Manager;

use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Repository\CurrencyRepositoryInterface;

class CurrencyManager
{
    /**
     * @var CurrencyRepositoryInterface
     */
    protected $currencyRepository;

    public function __construct(CurrencyRepositoryInterface $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @param string $code
     *
     * @return Currency
     */
    public function getByCode($code)
    {
        return $this->currencyRepository->getByCode($code);
    }
}