<?php

use App\Console\MigrationDownCommand;
use App\Console\MigrationUpCommand;
use App\View\Extensions\HelloWorldViewExtension;

return [
    'app' => [
        'environment' => env('APP_ENVIRONMENT', 'development'),
        'isProduction' => env('APP_ENVIRONMENT', 'production') === 'production',
        'url' => env('APP_URL', 'http://localhost'),
    ],

    'auth' => [
        'username' => 'admin',
        'password' => '1234',
    ],

    'db' => [
        'host' => env('MYSQL_HOST', 'localhost'),
        'port' => env('MYSQL_PORT', 3306),
        'database' => env('MYSQL_DATABASE'),
        'username' => env('MYSQL_USER'),
        'password' => env('MYSQL_PASSWORD'),
        'charset' => env('MYSQL_CHARSET', 'utf8'),
    ],

    'view' => [
        'templates_patch' => root_path('resources/templates'),
        'extensions' => [
            'helloWorld' => HelloWorldViewExtension::class,
        ],
    ],

    'console' => [
        'commands' => [
            'migration:up' => MigrationUpCommand::class,
            'migration:down' => MigrationDownCommand::class,
        ]
    ],
];