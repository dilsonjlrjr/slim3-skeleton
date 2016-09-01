<?php
return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../log/app.log',
        ],

        //session
        'session' => [
            'name' => 'SlimFramework3',
            'lifetime' => 7200,
            'path' => null,
            'domain' => null,
            'secure' => true,
            'httponly' => true,
            'cache_limiter' => 'nocache',
        ],

        //Database - Doctrine ODM
        'database' => [
            'connection' => [
                'user' => 'admin',
                'password' => '123456',
                'server' => 'localhost',
                'dbname' => 'BD_MOODLE_REST',
                'port' => '27017',
            ],
            'configuration' => [
                'ProxyDir' =>  __DIR__ . '/../cache/DoctrineMongoDB/Proxy/',
                'HydratorsDir' => __DIR__ . '/../cache/DoctrineMongoDB/Hydrators/',
                'DirectoryMapping' => __DIR__ . '/src/Mapper/',
            ]
        ],
    ],
];
