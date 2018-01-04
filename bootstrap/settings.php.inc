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
            'name' => 'UpSlimSession',
            'lifetime' => 7200,
            'path' => null,
            'domain' => null,
            'secure' => true,
            'httponly' => true,
            'cache_limiter' => 'nocache',
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
