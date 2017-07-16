<?php
use Weeks\CurrencyWatcher\Application\Controller\SiteController;

require __DIR__ . '/../bootstrap.php';

$app->get('/', SiteController::class . '::index');

$app->run();