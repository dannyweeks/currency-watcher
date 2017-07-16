<?php

namespace Weeks\CurrencyWatcher\Application\Repository;

use Doctrine\ORM\EntityRepository;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;
use Weeks\CurrencyWatcher\Domain\Repository\RateRepositoryInterface;

class RateRepository extends EntityRepository implements RateRepositoryInterface
{
    /**
     * @param Currency $baseCurrency
     * @param Currency $targetCurrency
     *
     * @return Rate
     */
    public function getLatestRate(Currency $baseCurrency, Currency $targetCurrency)
    {
        return $this->findOneBy(
            [
                'baseCurrency'   => $baseCurrency,
                'targetCurrency' => $targetCurrency,
            ],
            [
                'quotedAt' => 'DESC',
            ]
        );
    }

    /**
     * @param Rate $rate
     *
     * @return Rate
     */
    public function save(Rate $rate)
    {
        $this->getEntityManager()->persist($rate);
        $this->getEntityManager()->flush();

        return $rate;
    }
}