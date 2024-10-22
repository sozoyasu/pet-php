<?php

return [
    'auth' => [
        'username' => 'admin',
        'password' => '1234',
    ],

    'db' => [
        'host' => env('MYSQL_HOST', 'localhost'),
        'database' => env('MYSQL_DATABASE'),
        'username' => env('MYSQL_USER'),
        'password' => env('MYSQL_PASSWORD'),
    ],

    'view' => [
        'templates_patch' => root_path('view'),
    ],
];