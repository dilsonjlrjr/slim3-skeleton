<?php

/*
|--------------------------------------------------------------------------
| Example structure
|--------------------------------------------------------------------------
|
| doctrine-odm  ->  The driver to be used by the facilitator
| facilitator   ->  Class name facilitator. The facilitator is responsible
|                   for opening the connection to the database
|
| Note: The other settings are the responsibility of the driver are
| requirements , not being compulsory for the facilitator .
|
*/

return [
    'driver' => 'pdo',
    'boot-database' => false,

    'doctrine-odm' => [
        'facilitator' => \App\Facilitator\Database\Drivers\Doctrine\DoctrineODM::class,
        'connection' => [
            'username' => '',
            'password' => '',
            'server' => '',
            'dbname' => '',
            'port' => '27017',
        ],
        'configuration' => [
            'ProxyDir' =>  __DIR__ . '/../cache/DoctrineMongoDB/Proxy/',
            'HydratorsDir' => __DIR__ . '/../cache/DoctrineMongoDB/Hydrators/',
            'DirectoryMapping' => __DIR__ . '/src/Mapper/',
        ]
    ],

    'doctrine-orm' => [
        'facilitator' => \App\Facilitator\Database\Drivers\Doctrine\DoctrineORM::class,
        'connection' => [
            'username' => '',
            'password' => '',
            'server' => '',
            'dbname' => '',
            'port' => '3306',
            'driver' => '',
            'charset' => '',
        ],
        'configuration' => [
            'ProxyDir' =>  __DIR__ . '/../cache/DoctrineORM/Proxy/',
            'DirectoryMapping' => __DIR__ . '/src/Mapper/',
        ]
    ],

    'moloquent' => [
        'facilitator' => \App\Facilitator\Database\Drivers\Eloquent\Moloquent::class,
        'connection' => [
            'driver' => 'mongodb',
            'host' => '',
            'port' => 27017,
            'database' => '',
            'username' => '',
            'password' => '',
            'use_mongo_id' => false,
            'use_collection' => true
        ],
    ],

    'eloquent' => [
        'facilitator' => \App\Facilitator\Database\Drivers\Eloquent\Eloquent::class,
        'connection' => [
            'driver' => 'mysql',
            'host' => '',
            'database' => '',
            'username' => '',
            'password' => '',
            'charset'   => '',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
    ],

    'pdo' => [
        'facilitator' => \App\Facilitator\Database\Drivers\PDO\PDO::class,
        'connection' => [
            'dsn' => '',
            'username' => '',
            'password' => '',
            'charset'   => '',
        ],
    ]
];