<?php
// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// Flash messages
$container['flash'] = function (\Interop\Container\ContainerInterface $c) {
    return new Slim\Flash\Messages;
};


// monolog
$container['logger'] = function (\Interop\Container\ContainerInterface $c) {
    $settings = $c->get('settings');
    $logger = new Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['logger']['path'], Monolog\Logger::DEBUG));
    return $logger;
};

// Database Connection
$container['database'] = function (\Interop\Container\ContainerInterface $c) {
    return \App\Facilitator\Database\DatabaseFacilitator::getConnection();
};

//Error Handler
$container['errorHandler'] = function (\Interop\Container\ContainerInterface $c) {
    return function ($request, $response, $exception) use ($c) {
        $arrayJson = [ "code" => $exception->getCode(), "message" => 'Something went wrong! Cause: ' . $exception->getMessage()];

        return $c['response']->withStatus(500)
            ->withHeader('Content-Type', 'text/html')
            ->withJson($arrayJson);
    };
};

//Session Slim 3
$container['session'] = function (\Interop\Container\ContainerInterface $c) {
    return new \RKA\Session();
};

