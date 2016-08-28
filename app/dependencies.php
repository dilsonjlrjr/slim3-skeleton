<?php
// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------



// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------


// Flash messages
$container['flash'] = function ($c) {
    return new Slim\Flash\Messages;
};


// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['logger']['path'], Monolog\Logger::DEBUG));
    return $logger;
};

// Database Connection
$container['_dm'] = function (\Interop\Container\ContainerInterface $c) {

    $settings = $c->get('settings');

    $connectionString = 'mongodb://';

    $user     = $settings['database']['connection']['user'];
    $password = $settings['database']['connection']['password'];
    $dbName   = $settings['database']['connection']['dbname'];

    if ($user && $password) {
        $connectionString .= $user . ':' . $password . '@';
    }

    $connectionString .= $settings['database']['connection']['server'] . ':' . $settings['database']['connection']['port'];

    if ($dbName) {
        $connectionString .= '/' . $dbName;
    }

    // -----------------------------------------------------------------------------
    // Configuration
    // -----------------------------------------------------------------------------
    $configuration = new \Doctrine\ODM\MongoDB\Configuration();
    $configuration->setDefaultDB($dbName);

    /**
     * TODO Criar funcionalidade para gerar o diretório automático
     */
    $configuration->setProxyDir($settings['database']['configuration']['ProxyDir']);
    $configuration->setProxyNamespace('Proxies');
    $configuration->setHydratorDir($settings['database']['configuration']['HydratorsDir']);
    $configuration->setHydratorNamespace('Hydrators');

    $configuration->setMetadataDriverImpl(\Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver::create($settings['database']['configuration']['DirectoryMapping']));
    $configuration->setRetryConnect(true);

    \Doctrine\ODM\MongoDB\Mapping\Driver\AnnotationDriver::registerAnnotationClasses();

    $connection = new \Doctrine\MongoDB\Connection($connectionString, [], $configuration);

    $_dm = \Doctrine\ODM\MongoDB\DocumentManager::create($connection, $configuration);

    try {
        $_dm->getConnection()->connect();
        $_dm->getConnection()->isConnected();
        $_dm->getConnection()->close();
    } catch(\Exception $ex) {
        throw $ex;
    }

    return $_dm;

};

//Error Handler
$container['errorHandler'] = function ($c) {
    return function ($request, $response, $exception) use ($c) {
        $arrayJson = [ "code" => $exception->getCode(), "message" => 'Something went wrong! Cause: ' . $exception->getMessage()];

        return $c['response']->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->withJson($arrayJson);
    };
};

