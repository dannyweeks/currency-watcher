<?php

namespace Weeks\CurrencyWatcher\Application\Controller;

use Psr\Container\ContainerInterface;
use Slim\Views\Twig;

abstract class BaseController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return Twig
     */
    protected function getTwig()
    {
        return $this->container->get('twig');
    }
}