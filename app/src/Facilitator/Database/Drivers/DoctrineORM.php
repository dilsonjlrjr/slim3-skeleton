<?php

namespace App\Facilitator\Database\Drivers;

use App\Facilitator\App\ContainerFacilitator;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;

class DoctrineORM
{
    function __invoke() : EntityManager
    {
        $appContainer = ContainerFacilitator::getContainer();
        $databaseSettings = $appContainer->get('database-settings');
        $settings = $databaseSettings->get($databaseSettings->get('driver'));

        $user     = $settings['connection']['user'];
        $password = $settings['connection']['password'];
        $dbName   = $settings['connection']['dbname'];
        $server   = $settings['connection']['server'];
        $port     = $settings['connection']['port'];
        $driver   = $settings['connection']['driver'];
        $charset  = $settings['connection']['charset'];

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
        $configuration = Setup::createAnnotationMetadataConfiguration([$settings['configuration']['DirectoryMapping']], false);
        $configuration->setAutoGenerateProxyClasses(true);

        /**
         * TODO Criar funcionalidade para gerar o diretório automático
         */
        $configuration->setProxyDir($settings['configuration']['ProxyDir']);
        $configuration->setProxyNamespace('Proxies');

        $configuration->setMetadataDriverImpl(AnnotationDriver::create($settings['configuration']['DirectoryMapping']));

        return EntityManager::create($dbParams, $configuration);
    }
}