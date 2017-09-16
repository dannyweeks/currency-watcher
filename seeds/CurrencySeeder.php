<?php

namespace CurrencyWatcher\Seeder;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;

class CurrencySeeder implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $added = [];
        foreach ($this->getCountries() as $country) {
            $code = $country['ISO4217-currency_alphabetic_code'];
            if (in_array($code, $added)) {
                continue;
            }
            $added[] = $code;
            $manager->persist(new Currency($code, '', ''));
        }

        $manager->flush();
    }

    /**
     * @return array
     */
    protected function getCountries()
    {
        return json_decode(
            file_get_contents(__DIR__ . '/data/country-codes.json'),
            true
        );
    }
}