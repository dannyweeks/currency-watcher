<?php

namespace Weeks\CurrencyWatcher\Application;

use DI\ContainerBuilder;

class App extends \DI\Bridge\Slim\App
{
    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->useAutowiring(true);
        $builder->addDefinitions(array_merge(
                require __DIR__ . '/../../config/config.php',
                require __DIR__ . '/../../config/services.php'
        ));
    }
}