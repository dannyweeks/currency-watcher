<?php
return [
    'mail'                         => [
        'host'     => env('MAIL_HOST'),
        'port'     => 2525,
        'username' => env('MAIL_USERNAME'),
        'password' => env('MAIL_PASSWORD'),
        'from'     => env('MAIL_FROM'),
        'mailgun'  => [
            'secret' => env('MAILGUN_SECRET'),
            'domain' => env('MAILGUN_DOMAIN'),
        ],
    ],
    'db'                           => [
        'driver' => 'pdo_sqlite',
        'path'   => __DIR__ . '/../db.sqlite',
    ],
    'settings.displayErrorDetails' => true,
    'notification' =>  [
        'emailRecipients' => explode(',', env('NOTIFICATION_EMAIL_RECIPIENTS')),
    ],
];