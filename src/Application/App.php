<?php

namespace Weeks\CurrencyWatcher\Application;

use DI\ContainerBuilder;

class App extends \DI\Bridge\Slim\App
{
    const ENV_PRODUCTION = 'production';

    /**
     * @var string
     */
    private $environment;
    /**
     * @var
     */
    private $applicationRoot;

    /**
     * App constructor.
     *
     * @param string|null $environment
     * @param string      $applicationRoot
     */
    public function __construct($environment, $applicationRoot)
    {
        $this->environment = $environment ?: self::ENV_PRODUCTION;
        $this->applicationRoot = $applicationRoot;
        parent::__construct();
    }

    protected function configureContainer(ContainerBuilder $builder)
    {
        $builder->useAutowiring(true);
        $builder->addDefinitions(array_merge(
            require __DIR__ . '/../../config/config.php',
            require __DIR__ . '/../../config/services.php',
            [
                'env'     => $this->environment,
                'appRoot' => $this->applicationRoot,
            ]
        ));
    }
}