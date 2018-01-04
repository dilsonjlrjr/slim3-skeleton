<?php

namespace App\Facilitator\Database;


use App\Facilitator\App\ContainerFacilitator;
use Interop\Container\ContainerInterface;

class DatabaseFacilitator
{
    private static $connection;

    /**
     * @param $name
     * @return mixed
     */
    public static function fabConnection($name) {
        self::validateContainerFileDatabase($appContainer, $name);
        $databaseSettings = $appContainer->get('database-settings');
        $arrayDatabaseConfig = $databaseSettings->get($name);

        $classDatabase = $arrayDatabaseConfig['facilitator'];

        $databaseInstance = new $classDatabase($name);
        return $databaseInstance->fabConnection();
    }

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

        $databaseInstance = new $classDatabase($databaseSettings->get('driver'));
        self::$connection = $databaseInstance->createConnection();

        return self::$connection;
    }

    /**
     * @param ContainerInterface $container
     * @param string $name optional
     * @throws \Exception
     */
    private static function validateContainerFileDatabase(ContainerInterface $container, $name = "") {
        if (! $container->has('database-settings')) {
            throw new \Exception('File database configuration unspecified.');
        }

        $databaseSettings = $container->get('database-settings');
        if (strlen($name) > 0) {
            if (!$databaseSettings->has($name)) {
                throw new \Exception('The driver the file database settings unspecified.');
            }
        } else {
            if ((!$databaseSettings->has('driver')) || (!$databaseSettings->has($databaseSettings->get('driver')))) {
                throw new \Exception('The driver the file database settings unspecified.');
            }
        }
    }

    public static function destroyConnection() {
        self::$connection = null;
    }

}