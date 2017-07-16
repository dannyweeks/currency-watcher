<?php

namespace Weeks\CurrencyWatcher\Domain\Manager;

use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;
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

        var_dump($rate);die;

        return $this->rateRepository->save($rate);
    }
}