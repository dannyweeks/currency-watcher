<?php
use Weeks\CurrencyWatcher\Application\Controller\SiteController;

require __DIR__ . '/../bootstrap.php';

$app->get('/history/{base}/{target}', SiteController::class . '::history');

$app->run();