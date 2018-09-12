<?php
return [
    'settings.displayErrorDetails' => getenv('DEBUG'),
    'settings.db' => [
        'driver' => 'mysql',
        'host' => getenv('SQL_HOST'),
        'database' => getenv('SQL_DB'),
        'username' => getenv('SQL_USER'),
        'password' => getenv('SQL_PASS'),
        'charset' => getenv('SQL_CHARSET'),
        'collation' => getenv('SQL_COLLATION')
    ],
    'settings.logger' => [
        'name' => 'my_logger',
        'path' => '../logs/app.log'
    ],
    'settings.twig' => [
        'path' => BASE_PATH . '/resources/templates',
        'settings' => [
            'cache_path' => BASE_PATH . '/cache',
            'debug' => getenv('DEBUG'),
            'auto_reload' => getenv('DEBUG')
        ]
    ]
];
