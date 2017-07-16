<?php
return [
    'db'                           => [
        'driver' => 'pdo_sqlite',
        'path'   => __DIR__ . '/../db.sqlite',
    ],
    'settings.displayErrorDetails' => true,
    'currencyLayer'                => [
        'accessKey' => env('CURRENCY_LAYER_ACCESS_KEY'),
    ],
];