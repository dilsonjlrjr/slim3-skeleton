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
    'driver' => 'moloquent',
    'boot-database' => false,

    'doctrine-odm' => [
        'facilitator' => \App\Facilitator\Database\Drivers\DoctrineODM::class,
        'connection' => [
            'user' => '',
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
        'facilitator' => \App\Facilitator\Database\Drivers\DoctrineORM::class,
        'connection' => [
            'user' => '',
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
        'facilitator' => \App\Facilitator\Database\Drivers\Moloquent::class,
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

    'pdo' => []
];