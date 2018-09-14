<?php
return [
    'settings.displayErrorDetails' => getenv('DEBUG'),
    'settings.db' => [
        'driver' => getenv('DB_DRIVER'),
        'host' => getenv('DB_HOST'),
        'database' => getenv('DB_NAME'),
        'username' => getenv('DB_USER'),
        'password' => getenv('DB_PASS'),
        'charset' => getenv('DB_CHARSET'),
        'collation' => getenv('DB_COLLATION')
    ],
    'settings.logger' => [
        'name' => 'my_logger',
        'path' => __DIR__ . '/../logs/app.log'
    ],
    'settings.twig' => [
        'path' => __DIR__ . '/../resources/templates',
        'settings' => [
            'cache_path' => __DIR__ . '/../cache',
            'debug' => getenv('DEBUG'),
            'auto_reload' => getenv('DEBUG')
        ]
    ]
];
