<?php
return [
    'settings' => [
        // TODO: find a way to remove safely all this config (use defaults in slim-di-bridge)
        'httpVersion' => '1.1',
        'responseChunkSize' => 4096,
        'outputBuffering' => 'append',
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => false,
        'addContentLengthHeader' => true,
        'routerCacheFile' => false,

        'displayErrorDetails' => getenv('DEBUG'),
        'db' => [
            'driver' => 'mysql',
            'host' => getenv('SQL_HOST'),
            'database' => getenv('SQL_DB'),
            'username' => getenv('SQL_USER'),
            'password' => getenv('SQL_PASS'),
            'charset' => getenv('SQL_CHARSET'),
            'collation' => getenv('SQL_COLLATION')
        ],
        'logger' => [
            'name' => 'my_logger',
            'path' => '../logs/app.log'
        ],
        'twig' => [
            'path' => BASE_PATH . '/resources/templates',
            'settings' => [
                'cache_path' => BASE_PATH . '/cache',
                'debug' => getenv('DEBUG'),
                'auto_reload' => getenv('DEBUG')
            ]
        ]
    ],
];
