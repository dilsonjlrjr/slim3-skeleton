<?php

namespace App\Facilitator\Database\Drivers;

use App\Facilitator\App\ContainerFacilitator;
use Doctrine\Common\Cache\ApcCache;
use Interop\Container\ContainerInterface;

use Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver;
use Doctrine\MongoDB\Connection;
use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\Configuration;


class DoctrineODM
{
    function __invoke() : DocumentManager
    {
        $appContainer = ContainerFacilitator::getContainer();
        $databaseSettings = $appContainer->get('database-settings');
        $settings = $databaseSettings->get($databaseSettings->get('driver'));

        $connectionString = 'mongodb://';

        $user     = $settings['connection']['user'];
        $password = $settings['connection']['password'];
        $dbName   = $settings['connection']['dbname'];

        if ($user && $password) {
            $connectionString .= $user . ':' . $password . '@';
        }

        $connectionString .= $settings['connection']['server'] . ':' . $settings['connection']['port'];

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
        $configuration->setProxyDir($settings['configuration']['ProxyDir']);
        $configuration->setProxyNamespace('Proxies');
        $configuration->setHydratorDir($settings['configuration']['HydratorsDir']);
        $configuration->setHydratorNamespace('Hydrators');

        $configuration->setMetadataDriverImpl(AnnotationDriver::create($settings['configuration']['DirectoryMapping']));
//        $configuration->setMetadataCacheImpl(new ApcCache());
        $configuration->setRetryConnect(true);

        AnnotationDriver::registerAnnotationClasses();

        $connection = new Connection($connectionString, [], $configuration);

        $_dm = DocumentManager::create($connection, $configuration);

        return $_dm;
    }
}