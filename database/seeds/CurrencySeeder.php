<?php

namespace CurrencyWatcher\Seeder;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;

class CurrencySeeder extends AbstractFixture implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     * @todo clean up this method
     */
    public function load(ObjectManager $manager)
    {
        $codes = [];
        foreach ($this->getCountries() as $country) {
            $code = $country['ISO4217-currency_alphabetic_code'];
            if (in_array($code, $codes) || empty($code)) {
                continue;
            }
            $codes[] = $code;
        }

        sort($codes);

        foreach ($codes as $code) {
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