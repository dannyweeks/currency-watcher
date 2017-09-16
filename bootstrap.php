<?php

require 'vendor/autoload.php';

use Weeks\CurrencyWatcher\Application\App;

if (file_exists(__DIR__ . '/.env')) {
    $dotEnv = new Dotenv\Dotenv(__DIR__);
    $dotEnv->load();
}

$app = new App(env('APP_ENV', App::ENV_PRODUCTION), __DIR__);