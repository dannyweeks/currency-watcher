<?php
require 'vendor/autoload.php';

if (file_exists(__DIR__ . '/.env')) {
    $dotEnv = new Dotenv\Dotenv(__DIR__);
    $dotEnv->load();
}

$app = new \Weeks\CurrencyWatcher\Application\App();