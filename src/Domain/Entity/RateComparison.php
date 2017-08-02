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

        switch (true) {
            case $change < 0:
                $message = 'Decrease by %1$s (from %2$s)';
                break;
            case $change > 0:
                $message = 'Increase by %1$s (from %2$s)';
                break;
            case $this->from->getValue() == $this->to->getValue():
                $message = 'No change since %3$s';
                break;
            case $this->from === $this->to:
            default:
                $message = '';
        }

        return sprintf(
            $message,
            $change,
            $this->from->getValue(),
            $this->from->getQuotedAt()->format('H:i d/m/Y')
        );
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->forHuman();
    }
}