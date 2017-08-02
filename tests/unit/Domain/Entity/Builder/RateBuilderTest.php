<?php

use Weeks\CurrencyWatcher\Domain\Entity\Builder\RateBuilder;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;

class RateBuilderTest extends \PHPUnit_Framework_TestCase
{
    protected $baseCurrency;
    protected $targetCurrency;

    public function setUp()
    {
        $this->baseCurrency = new Currency('BASE', '', '');
        $this->targetCurrency = new Currency('TARGET', '', '');
    }

    /**
    * @test
    */
    public function it_applies_the_transaction_charge_to_the_value()
    {
        $rate = (new RateBuilder())
            ->setBaseCurrency($this->baseCurrency)
            ->setTargetCurrency($this->targetCurrency)
            ->setQuotedAt($this->getDate('2017-01-01 00:00'))
            ->setValue(130.3201)
            ->build()
        ;

        $this->assertInstanceOf(Rate::class, $rate);
        $this->assertEquals(126.7363, $rate->getValue());
    }

    /**
     * @param string $date
     * @param string $format
     *
     * @return DateTime
     */
    protected function getDate($date, $format = 'Y-m-d H:i')
    {
        return \DateTime::createFromFormat($format, $date);
    }
}