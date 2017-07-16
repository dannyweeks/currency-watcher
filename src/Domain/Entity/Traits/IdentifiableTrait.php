<?php

namespace Weeks\CurrencyWatcher\Domain\Entity\Traits;

trait IdentifiableTrait
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}