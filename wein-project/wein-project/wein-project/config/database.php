<?php

use Illuminate\Support\Str;

return [

    'default' => env('DB_CONNECTION', 'sqlsrv'),

    'connections' => [

        'sqlsrv' => [
            'driver'    => 'sqlsrv',
            'url'       => env('DATABASE_URL'),
            'host'      => env('DB_HOST', '127.0.0.1'),
            'port'      => env('DB_PORT', '1433'),
            'database'  => env('DB_DATABASE', 'weInDB'),
            'username'  => env('DB_USERNAME', 'sa'),
            'password'  => env('DB_PASSWORD', ''),
            'charset'   => 'utf8',
            'prefix'    => '',
            'prefix_indexes' => true,
        ],

        'sqlite' => [
            'driver'                  => 'sqlite',
            'url'                     => env('DATABASE_URL'),
            'database'                => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix'                  => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

    ],

    'migrations' => [
        'table'  => 'migrations',
        'update_date_on_publish' => true,
    ],

    'redis' => [
        'client' => env('REDIS_CLIENT', 'phpredis'),
        'default' => [
            'host'     => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD'),
            'port'     => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],
    ],

];
