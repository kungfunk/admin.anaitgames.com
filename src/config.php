<?php
return [
    'settings' => [
        'displayErrorDetails' => getenv('DEBUG'),
        'logger' => [
            'name' => 'logger',
            'path' => __DIR__ . '/../logs/app.log'
        ],
        'twig' => [
            'path' => __DIR__ . '/../resources/templates',
            'settings' => [
                'cache' => __DIR__ . '/../cache',
                'debug' => getenv('DEBUG'),
                'auto_reload' => getenv('DEBUG')
            ]
        ],
        'session' => [
            'name' => getenv('SESSION_NAME'),
            'autorefresh' => true,
            'lifetime' => getenv('SESSION_LIFETIME')
        ],
        'db' => [
            'driver' => getenv('DB_DRIVER'),
            'host' => getenv('DB_HOST'),
            'database' => getenv('DB_NAME'),
            'username' => getenv('DB_USER'),
            'password' => getenv('DB_PASS'),
            'charset' => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION')
        ]
    ]
];
