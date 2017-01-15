<?php

namespace App\Facilitator\Database\Drivers\Doctrine;

use App\Facilitator\App\ContainerFacilitator;
use App\Facilitator\Database\Drivers\IConnection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;

class DoctrineORM implements IConnection
{

    /**
     * @var EntityManager\
     */
    protected static $em;

    /**
     * @var array
     */
    private $connectionConfig;

    /**
     * DoctrineORM constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        $appContainer = ContainerFacilitator::getContainer();
        $databaseSettings = $appContainer->get('database-settings');
        $this->connectionConfig = $databaseSettings->get($name);
    }

    /**
     * @return EntityManager
     */
    function fabConnection() : EntityManager
    {
        $user     = $this->connectionConfig['connection']['user'];
        $password = $this->connectionConfig['connection']['password'];
        $dbName   = $this->connectionConfig['connection']['dbname'];
        $server   = $this->connectionConfig['connection']['server'];
        $port     = $this->connectionConfig['connection']['port'];
        $driver   = $this->connectionConfig['connection']['driver'];
        $charset  = $this->connectionConfig['connection']['charset'];

        $dbParams = [
            'driver'   => $driver,
            'user'     => $user,
            'password' => $password,
            'dbname'   => $dbName,
            'host' => $server,
            'port' => $port,
            'charset' => $charset,
        ];

        // -----------------------------------------------------------------------------
        // Configuration
        // -----------------------------------------------------------------------------
        $configuration = Setup::createAnnotationMetadataConfiguration([$this->connectionConfig['configuration']['DirectoryMapping']], false);
        $configuration->setAutoGenerateProxyClasses(true);

        /**
         * TODO Criar funcionalidade para gerar o diretório automático
         */
        $configuration->setProxyDir($this->connectionConfig['configuration']['ProxyDir']);
        $configuration->setProxyNamespace('Proxies');

        $configuration->setMetadataDriverImpl(AnnotationDriver::create($this->connectionConfig['configuration']['DirectoryMapping']));

        return EntityManager::create($dbParams, $configuration);
    }

    /**
     * @return EntityManager
     */
    function createConnection() : EntityManager
    {
        return $this->fabConnection();
    }

    /**
     * @return EntityManager
     */
    function getConnection() : EntityManager
    {
        return self::$em;
    }
}