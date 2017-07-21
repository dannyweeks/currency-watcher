<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Swap\Swap;
use Weeks\CurrencyWatcher\Application\Gateway\SwapRateGateway;
use Weeks\CurrencyWatcher\Application\Mailer\SwiftMailer;
use Weeks\CurrencyWatcher\Domain\Entity\Currency;
use Weeks\CurrencyWatcher\Domain\Entity\Rate;
use Weeks\CurrencyWatcher\Domain\Gateway\RateGatewayInterface;
use Weeks\CurrencyWatcher\Domain\Mailer\MailerInterface;
use Weeks\CurrencyWatcher\Domain\Repository\CurrencyRepositoryInterface;
use Weeks\CurrencyWatcher\Domain\Repository\RateRepositoryInterface;

return [
    EntityManager::class => function (ContainerInterface $c) {
        $doctrineConfig = Setup::createYAMLMetadataConfiguration(
            [
                __DIR__ . "/doctrine"
            ],
            true
        );

        return EntityManager::create(
            $c->get('db'),
            $doctrineConfig
        );
    },

    CurrencyRepositoryInterface::class => function (ContainerInterface $c) {
        return $c->get(EntityManager::class)
            ->getRepository(Currency::class);
    },

    RateRepositoryInterface::class => function (ContainerInterface $c) {
        return $c->get(EntityManager::class)
            ->getRepository(Rate::class);
    },

    Swap::class => function (ContainerInterface $c) {

        return (new \Swap\Builder())
            ->add('google')
            ->build();
    },

    RateGatewayInterface::class => function (ContainerInterface $c) {
        return $c->get(SwapRateGateway::class);
    },


    \Swift_Mailer::class => function (ContainerInterface $c) {
        $mailConfig = $c->get('mail');
        $transport = new Swift_SmtpTransport(
            $mailConfig['host'],
            $mailConfig['port']
        );

        $transport->setUsername($mailConfig['username'])
            ->setPassword($mailConfig['password']);

        return \Swift_Mailer::newInstance($transport);
    },

    MailerInterface::class => function (ContainerInterface $c) {
        return new SwiftMailer(
            $c->get(\Swift_Mailer::class),
            $c->get('mail')['from']
        );
    }
];