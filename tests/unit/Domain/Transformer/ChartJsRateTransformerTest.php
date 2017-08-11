<?php

use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;
use Weeks\CurrencyWatcher\Domain\Transformer\ChartJsRateTransformer;

class ChartJsRateTransformerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Currency
     */
    protected $baseCurrency;

    /**
     * @var Currency
     */
    protected $targetCurrency;

    public function setUp()
    {
        $this->baseCurrency = new Currency('BASE', '', '');
        $this->targetCurrency = new Currency('TARGET', '', '');
    }

    /**
    * @test
    */
    public function it_outputs_the_labels()
    {
        $transformer = new ChartJsRateTransformer();
        $rate1Date = '2017-01-01';
        $rate2Date = '2017-01-02';
        $transformer->setData(
            [
                $this->getRate(
                    111,
                    $this->getDate($rate1Date, 'Y-m-d')
                ),
                $this->getRate(
                    112,
                    $this->getDate($rate2Date, 'Y-m-d')
                )
            ]
        );

        $result = $transformer->transform();

        $this->assertArrayHasKey('labels', $result);
        $this->assertCount(2, $result['labels']);
        $this->assertEquals($rate1Date, $result['labels'][0]);
        $this->assertEquals($rate2Date, $result['labels'][1]);
    }

    /**
    * @test
    */
    public function it_creates_the_data_set()
    {
        $transformer = new ChartJsRateTransformer();
        $rate1Date = '2017-01-01';
        $rate2Date = '2017-01-02';
        $transformer->setData(
            [
                $this->getRate(
                    111.21,
                    $this->getDate($rate1Date, 'Y-m-d')
                ),
                $this->getRate(
                    112.12,
                    $this->getDate($rate2Date, 'Y-m-d')
                )
            ]
        );

        $label = $this->baseCurrency->getCode() . ' to ' . $this->targetCurrency->getCode();

        $result = $transformer
            ->setLabel($label)
            ->transform();

        $this->assertArrayHasKey('datasets', $result);
        $this->assertCount(1, $result['datasets']);
        $dataSet = $result['datasets'][0];
        $this->assertArrayHasKey('label', $dataSet);
        $this->assertEquals(
            $label,
            $dataSet['label']
        );
        $this->assertArrayHasKey('data', $dataSet);
        $data = $dataSet['data'];
        $this->assertCount(2, $data);
        $this->assertEquals(111.21, $data[0]);
        $this->assertEquals(112.12, $data[1]);
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