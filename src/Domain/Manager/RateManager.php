<?php

namespace Weeks\CurrencyWatcher\Domain\Manager;

use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;
use Weeks\CurrencyWatcher\Domain\Entity\RateComparison;
use Weeks\CurrencyWatcher\Domain\Gateway\RateGatewayInterface;
use Weeks\CurrencyWatcher\Domain\Repository\RateRepositoryInterface;

class RateManager
{
    /**
     * @var RateRepositoryInterface
     */
    protected $rateRepository;

    /**
     * @var RateGatewayInterface
     */
    protected $rateGateway;

    /**
     * @param RateGatewayInterface    $rateGateway
     * @param RateRepositoryInterface $rateRepository
     */
    public function __construct(
        RateGatewayInterface $rateGateway,
        RateRepositoryInterface $rateRepository
    ) {
        $this->rateGateway = $rateGateway;
        $this->rateRepository = $rateRepository;
    }

    /**
     * @param Currency $baseCurrency
     * @param Currency $targetCurrency
     *
     * @return Rate $rate
     */
    public function fetchNewRate(Currency $baseCurrency, Currency $targetCurrency)
    {
        $rate = $this->rateGateway
            ->getCurrentRate(
                $baseCurrency,
                $targetCurrency
            );

        return $this->rateRepository->save($rate);
    }

    /**
     * @param Currency $baseCurrency
     * @param Currency $targetCurrency
     *
     * @return Rate
     */
    public function getLastRate(Currency $baseCurrency, Currency $targetCurrency)
    {
        return $this->rateRepository->lastRate($baseCurrency, $targetCurrency);
    }

    /**
     * @param Rate $from
     * @param Rate $to
     *
     * @return RateComparison
     */
    public function compare(Rate $from, Rate $to)
    {
        return new RateComparison($from, $to);
    }

    /**
     * @param Currency $base
     * @param Currency $target
     * @param int      $limit
     * @param int      $offset
     *
     * @return Rate[]
     */
    public function getHistoricalRates(Currency $base, Currency $target, $limit = 30, $offset = 0)
    {
        return array_reverse($this->rateRepository->search(
            $limit,
            $offset,
            $base,
            $target
        ));
    }

    /**
     * @param Currency $base
     * @param Currency $target
     *
     * @return Rate
     */
    public function getHighestRate(Currency $base, Currency $target)
    {
        $result = $this->rateRepository->search(1, 0, $base, $target, 'value');

        if (count($result) !== 1) {
            return null;
        }

        return $result[0];
    }

    /**
     * @param Currency $base
     * @param Currency $target
     *
     * @return Rate
     */
    public function getLowRate(Currency $base, Currency $target)
    {
        $result = $this->rateRepository->search(1, 0, $base, $target, 'value', 'ASC');

        if (count($result) !== 1) {
            return null;
        }

        return $result[0];
    }
}