<?php

namespace Weeks\CurrencyWatcher\Application\Command;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command;

abstract class ContainerAwareCommand extends Command
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container, $name)
    {
        parent::__construct($name);

        $this->container = $container;
    }

    /**
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->container;
    }
}