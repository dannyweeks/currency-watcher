<?php

namespace Weeks\CurrencyWatcher\Application\Controller;

use Psr\Container\ContainerInterface;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Weeks\CurrencyWatcher\Application\Repository\CurrencyRepository;
use Weeks\CurrencyWatcher\Domain\Manager\RateManager;
use Weeks\CurrencyWatcher\Domain\Repository\CurrencyRepositoryInterface;

class SiteController
{
    /**
     * @var CurrencyRepository
     */
    protected $currencyRepository;

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function index(Request $request, Response $response)
    {
        $repo = $this->container->get(CurrencyRepositoryInterface::class);

        $gbp = $repo->getByCode('gbp');
        $isk = $repo->getByCode('isk');

        $manager = $this->container->get(RateManager::class);

        $rate = $manager->fetchNewRate($gbp, $isk);

        return $response;
    }
}