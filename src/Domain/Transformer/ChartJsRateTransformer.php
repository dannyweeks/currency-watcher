<?php

namespace Weeks\CurrencyWatcher\Domain\Transformer;

use Weeks\CurrencyWatcher\Domain\Entity\Rate;

class ChartJsRateTransformer implements TransformerInterface
{
    protected $data = [];
    protected $label = '';

    /**
     * @param $rates
     *
     * @return $this
     *
     * @throws \Exception
     */
    public function setData($rates)
    {
        foreach ($rates as $rate) {
            if (!$rate instanceof Rate) {
                throw new \Exception('Data must be an array of ' . Rate::class . ' objects');
            }
        }

        $this->data = $rates;

        return $this;
    }

    /**
     * @param string $label
     *
     * @return $this
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return array
     */
    public function transform()
    {
        return [
            'labels' => $this->buildLabels(),
            'datasets' =>  [
                [
                    'label' =>  $this->label,
                    'data' => $this->buildData(),
                    'backgroundColor' =>  'rgba(128, 0, 128, 0.2)',
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    private function buildLabels()
    {
        return array_map(function(Rate $rate) {
            return $rate->getQuotedAt()->format('Y-m-d');
        }, $this->data);
    }

    /**
     * @return array
     */
    private function buildData()
    {
        return array_map(function(Rate $rate) {
            return $rate->getValue();
        }, $this->data);
    }
}