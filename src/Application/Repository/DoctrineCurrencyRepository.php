<?php

namespace Weeks\CurrencyWatcher\Application\Repository;

use Doctrine\ORM\EntityRepository;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Repository\CurrencyRepositoryInterface;

class DoctrineCurrencyRepository extends EntityRepository implements CurrencyRepositoryInterface
{
    /**
     * @param $code
     *
     * @return Currency
     */
    public function getByCode($code)
    {
        return $this->findOneBy(
            [
                'code' => strtoupper($code),
            ]
        );
    }

    /**
     * @param Currency $currency
     *
     * @return Currency
     */
    public function save(Currency $currency)
    {
        $this->getEntityManager()->persist($currency);
        $this->getEntityManager()->flush();

        return $currency;
    }
}