<?php

namespace Weeks\CurrencyWatcher\Application\Repository;

use PDO;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Repository\CurrencyRepositoryInterface;

class SqlCurrencyRepository implements CurrencyRepositoryInterface
{
    /**
     * @var PDO
     */
    private $db;

    /**
     * @var Hydrator
     */
    private $hydrator;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @param $code
     *
     * @return Currency
     */
    public function getByCode($code)
    {
        $query = $this->db->prepare(
            "SELECT * FROM currencies WHERE code = :code LIMIT 1"
        );
        $query->execute(['code' => strtoupper($code)]);

        if (!($result = $query->fetch())) {
            throw new \Exception('code not found'); // @todo domain exception
        }

        return;
    }

    /**
     * @param Currency $currency
     *
     * @return Currency
     */
    public function save(Currency $currency)
    {
        // TODO: Implement save() method.
    }

    /**
     * @param string|object $class
     * @param Currency $result
     */
    private function hydrate($class, $result)
    {

    }
}