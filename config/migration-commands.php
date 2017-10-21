<?php
use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand;
use Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

return [
    Configuration::class => function (ContainerInterface $c) {
        $config = new Configuration($c->get(EntityManager::class)->getConnection());
        $config->setName($c->get('migrations')['name']);
        $config->setMigrationsNamespace($c->get('migrations')['migrations_namespace']);
        $config->setMigrationsTableName($c->get('migrations')['table_name']);
        $config->setMigrationsDirectory($c->get('migrations')['migrations_directory']);

        return $config;
    },
    DiffCommand::class => function (ContainerInterface $c) {
        $command = new DiffCommand();
        $command->setMigrationConfiguration($c->get(Configuration::class));

        return $command;
    },
    ExecuteCommand::class => function (ContainerInterface $c) {
        $command = new ExecuteCommand();
        $command->setMigrationConfiguration($c->get(Configuration::class));

        return $command;
    },
    GenerateCommand::class => function (ContainerInterface $c) {
        $command = new GenerateCommand();
        $command->setMigrationConfiguration($c->get(Configuration::class));

        return $command;
    },
    MigrateCommand::class => function (ContainerInterface $c) {
        $command = new MigrateCommand();
        $command->setMigrationConfiguration($c->get(Configuration::class));

        return $command;
    },
    StatusCommand::class => function (ContainerInterface $c) {
        $command = new StatusCommand();
        $command->setMigrationConfiguration($c->get(Configuration::class));

        return $command;
    },
    VersionCommand::class => function (ContainerInterface $c) {
        $command = new VersionCommand();
        $command->setMigrationConfiguration($c->get(Configuration::class));

        return $command;
    }
];