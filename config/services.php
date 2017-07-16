<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Swap\Swap;
use Weeks\CurrencyWatcher\Application\Gateway\SwapRateGateway;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;
use Weeks\CurrencyWatcher\Domain\Gateway\RateGatewayInterface;
use Weeks\CurrencyWatcher\Domain\Repository\CurrencyRepositoryInterface;
use Weeks\CurrencyWatcher\Domain\Repository\RateRepositoryInterface;

return [
    EntityManager::class => \DI\factory(function ($db) {
        $doctrineConfig = Setup::createYAMLMetadataConfiguration(
            [
                __DIR__ . "/doctrine"
            ],
            true
        );

        return EntityManager::create(
            $db,
            $doctrineConfig
        );
    })->parameter('db', DI\get('db')),

    CurrencyRepositoryInterface::class => \DI\factory(function (EntityManager $em) {
        return $em->getRepository(Currency::class);
    }),

    RateRepositoryInterface::class => \DI\factory(function (EntityManager $em) {
        return $em->getRepository(Rate::class);
    }),

    Swap::class => \DI\factory(function (ContainerInterface $c) {

        return (new \Swap\Builder())
            ->add('currency_layer', [
                'access_key' => $c->get('currencyLayer')['accessKey'],
                'enterprise' => false
            ])->build();
    }),

    RateGatewayInterface::class => \DI\get(SwapRateGateway::class)
];