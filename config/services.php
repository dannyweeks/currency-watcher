<?php

use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\Mapping\Driver\SimplifiedYamlDriver;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Swap\Swap;
use Weeks\CurrencyWatcher\Application\Command\DbSeedCommand;
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
        $config = Setup::createYAMLMetadataConfiguration([], true);

        $driver = new SimplifiedYamlDriver([
            __DIR__ . '/doctrine' => 'Weeks\CurrencyWatcher\Domain\Entity'
        ]);

        $config->setMetadataDriverImpl($driver);

        return EntityManager::create(
            $c->get('db'),
            $config
        );
    },

    ORMExecutor::class => function (ContainerInterface $c) {
        return new ORMExecutor(
            $c->get(EntityManager::class),
            new ORMPurger()
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
    },

    'twig' => function (ContainerInterface $c) {
        $view = new \Slim\Views\Twig(__DIR__ . '/../templates', [
            'cache' => false
        ]);

        $basePath = rtrim(
            str_ireplace(
                'index.php',
                '',
                $c->get('request')->getUri()->getBasePath()
            ),
            '/'
        );

        $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $basePath));

        return $view;
    },

    DbSeedCommand::class => function (ContainerInterface $c) {
        return new DbSeedCommand(
            $c->get(Loader::class),
            $c->get(ORMExecutor::class),
            $c->get('appRoot') . '/database/seeds'
        );
    }
];