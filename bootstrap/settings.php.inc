<?php
return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,
        'dir_cache_controller' => __DIR__ . '/../storage/cache/Controller/',

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../log/app.log',
        ],

        //session
        'session' => [
            'name' => 'UpSlimSession',
            'lifetime' => 7200,
            'path' => null,
            'domain' => null,
            'secure' => true,
            'httponly' => true,
            'cache_limiter' => 'nocache',
        ],

        // Core config
        // Modify only as necessary
        'path-config' => [
            'middleware' => [
                'list' => __DIR__ . '/middlewares.php',
                'install' => __DIR__ . '/../app/Middleware',
            ],
            'modules' => [
                'list' => __DIR__ . '/modules.php',
                'install' => __DIR__ . '/../app/Modules',
            ],
            'providers' => [
                'list' => __DIR__ . '/providers.php',
                'install' => __DIR__ . '/../app/Providers',
            ]
        ],

        // View settings
        //'view' => [
        //    'template_path' => [
        //
        //        __DIR__ . '/../app/Modules/API/View',
        //
        //    ],
        //    'twig' => [
        //        'cache' => __DIR__ . '/../storage/cache/twig',
        //        'debug' => true,
        //        'auto_reload' => true,
        //    ],
        //],
    ],
];
