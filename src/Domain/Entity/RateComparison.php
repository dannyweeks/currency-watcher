<?php

namespace Weeks\CurrencyWatcher\Domain\Entity;

class RateComparison
{
    /**
     * @var Rate
     */
    protected $from;
    
    /**
     * @var Rate
     */
    protected $to;
    
    /**
     * @param Rate $from
     * @param Rate $to
     */
    public function __construct(Rate $from, Rate $to)
    {
        // @todo make sure the base/target currencies match.
        $this->from = $from;
        $this->to = $to;
    }

    /**
     * @return float
     */
    public function change()
    {
        return number_format($this->to->getValue() - $this->from->getValue(), 4);
    }

    /**
     * @return boolean
     */
    public function isPositiveChange()
    {
        return $this->change() > 0;
    }

    /**
     * @return boolean
     */
    public function isNegativeChange()
    {
        return $this->change() < 0;
    }

    /**
     * @return string
     */
    public function forHuman()
    {
        $change = $this->change();

        if ($this->from->getValue() == $this->to->getValue()) {
            return 'No change since ' . $this->from->getQuotedAt()->format('H:i d/m/Y');
        }

        if ($change > 0) {
            return sprintf(
                "Increase by %s (from %s)",
                $change,
                $this->from->getValue()
            );
        }

        if ($change < 0) {
            return sprintf(
                "Decrease by %s (from %s)",
                $change,
                $this->from->getValue()
            );
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->forHuman();
    }
}