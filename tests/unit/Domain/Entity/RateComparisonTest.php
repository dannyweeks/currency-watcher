<?php

use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;
use Weeks\CurrencyWatcher\Domain\Entity\RateComparison;

class RateComparisonTest extends \PHPUnit_Framework_TestCase
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
    public function it_calculates_the_a_negative_change()
    {
        $comp = new RateComparison(
            $this->getRate('2.134'),
            $this->getRate('2')
        );

        $this->assertEquals('-0.134', $comp->change());
        $this->assertTrue($comp->isNegativeChange());
    }

    /**
     * @test
     */
    public function it_calculates_the_a_positive_change()
    {
        $comp = new RateComparison(
            $this->getRate('2'),
            $this->getRate('2.134')
        );

        $this->assertEquals('0.134', $comp->change());
        $this->assertTrue($comp->isPositiveChange());
    }

    /**
     * @test
     */
    public function the_class_casts_into_human_readable_string()
    {
        $comp = new RateComparison(
            $this->getRate('2'),
            $this->getRate('2')
        );

        $this->assertTrue(is_string((string) $comp));
    }

    /**
     * @param float         $value
     * @param DateTime      $date
     * @param Currency|null $base
     * @param Currency|null $target
     *
     * @return Rate
     */
    protected function getRate(
        $value,
        \DateTime $date = null,
        Currency $base = null,
        Currency $target = null
    ) {
        if (!$base instanceof Currency) {
            $base = $this->baseCurrency;
        }

        if (!$target instanceof Currency) {
            $target = $this->targetCurrency;
        }

        if (!$date instanceof \DateTime) {
            $date = $this->getDate('2017-01-01 00:00');
        }

        return new Rate(
            $base,
            $target,
            $date,
            $value
        );
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