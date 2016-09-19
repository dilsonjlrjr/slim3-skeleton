<?php

namespace App\Facilitator\Database;


use App\Facilitator\App\ContainerFacilitator;
use Interop\Container\ContainerInterface;

class DatabaseFacilitator
{
    private static $connection;

    /**
     * Return connection active
     * @return mixed $connection
     */
    public static function getConnection() {

        if (self::$connection !== null) {
            return self::$connection;
        }

        $appContainer = ContainerFacilitator::getContainer();

        self::validateContainerFileDatabase($appContainer);
        $databaseSettings = $appContainer->get('database-settings');
        $arrayDatabaseConfig = $databaseSettings->get($databaseSettings->get('driver'));

        $classDatabase = $arrayDatabaseConfig['facilitator'];

        $databaseInstance = new $classDatabase();
        self::$connection = $databaseInstance();

        return self::$connection;
    }

    /**
     * @param ContainerInterface $container
     * @throws \Exception
     */
    private static function validateContainerFileDatabase(ContainerInterface $container) {
        if (! $container->has('database-settings')) {
            throw new \Exception('File database configuration unspecified.');
        }

        $databaseSettings = $container->get('database-settings');
        if ((!$databaseSettings->has('driver')) || (!$databaseSettings->has($databaseSettings->get('driver'))) ) {
            throw new \Exception('The driver the file database settings unspecified.');
        }
    }

    public static function destroyConnection() {
        self::$connection = null;
    }

}