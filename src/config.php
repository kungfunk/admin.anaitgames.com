<?php
return [
    'settings' => [
        'displayErrorDetails' => getenv('DEBUG'),
        'logger' => [
            'name' => 'my_logger',
            'path' => __DIR__ . '/../logs/app.log'
        ],
        'twig' => [
            'path' => __DIR__ . '/../resources/templates',
            'settings' => [
                'cache_path' => __DIR__ . '/../cache',
                'debug' => getenv('DEBUG'),
                'auto_reload' => getenv('DEBUG')
            ]
        ]
    ]
];
