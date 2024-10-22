<?php

return [
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
        'templates_patch' => root_path('view'),
    ],
];