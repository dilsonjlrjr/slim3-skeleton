<?php

namespace App\Facilitator\Database\Drivers\Doctrine;

use App\Facilitator\App\ContainerFacilitator;
use App\Facilitator\Database\Drivers\IConnection;
use Doctrine\Common\Cache\ApcCache;

use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Configuration;


class DoctrineODM implements IConnection
{

    /**
     * @var DocumentManager
     */
    protected static $dm;

    /**
     * @var array
     */
    private $connectionConfig;


    /**
     * DoctrineODM constructor.
     */
    public function __construct($name)
    {
        $appContainer = ContainerFacilitator::getContainer();
        $databaseSettings = $appContainer->get('database-settings');
        $this->connectionConfig = $databaseSettings->get($name);
    }

    /**
     * @return DocumentManager
     */
    function fabConnection() : DocumentManager
    {
        $connectionString = 'mongodb://';

        $user     = $this->connectionConfig['connection']['user'];
        $password = $this->connectionConfig['connection']['password'];
        $dbName   = $this->connectionConfig['connection']['dbname'];

        if ($user && $password) {
            $connectionString .= $user . ':' . $password . '@';
        }

        $connectionString .= $this->connectionConfig['connection']['server'] . ':' . $this->connectionConfig['connection']['port'];

        if ($dbName) {
            $connectionString .= '/' . $dbName;
        }

        // -----------------------------------------------------------------------------
        // Configuration
        // -----------------------------------------------------------------------------
        $configuration = new Configuration();
        $configuration->setDefaultDB($dbName);

        /**
         * TODO Criar funcionalidade para gerar o diretório automático
         */
        $configuration->setProxyDir($this->connectionConfig['configuration']['ProxyDir']);
        $configuration->setProxyNamespace('Proxies');
        $configuration->setHydratorDir($this->connectionConfig['configuration']['HydratorsDir']);
        $configuration->setHydratorNamespace('Hydrators');

        $configuration->setMetadataDriverImpl(AnnotationDriver::create($this->connectionConfig['configuration']['DirectoryMapping']));
//        $configuration->setMetadataCacheImpl(new ApcCache());
        $configuration->setRetryConnect(true);

        AnnotationDriver::registerAnnotationClasses();

        $connection = new Connection($connectionString, [], $configuration);

        $_dm = DocumentManager::create($connection, $configuration);

        return $_dm;
    }

    function createConnection() : DocumentManager
    {
        return $this->fabConnection();
    }

    function getConnection() : DocumentManager
    {
        return self::$dm;
    }
}