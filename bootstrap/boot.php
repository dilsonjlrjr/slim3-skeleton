<?php

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__ . '/../vendor/autoload.php';

// Instantiate the app
if (!file_exists(__DIR__ . '/settings.php'))
    throw new \Exception('File settings not exists. Create one in the bootstrap folder at the root of your project.');

$settings = require_once(__DIR__ . '/settings.php');
$app = new \App\UpSlim($settings);
\App\UpSlim::setInstance($app);


// -----------------------------------------------------------------------------
// Register routes
// -----------------------------------------------------------------------------
$pathController = require_once(__DIR__ . '/controllers.php');
\Slim3\Annotation\Slim3Annotation::create($app, $pathController, $settings['settings']['dir_cache_controller']);

//--------------------------------------------------------------------------
// Register Providers
//--------------------------------------------------------------------------
$providers = require_once(__DIR__ . '/providers.php');
foreach ($providers as $provider) {
    \App\Facilitator\App\ContainerFacilitator::register(new $provider);
}

//--------------------------------------------------------------------------
// Register Middlewares
//--------------------------------------------------------------------------
$middlewares = require_once(__DIR__ . '/middlewares.php');
foreach ($middlewares as $middleware) {
    \App\UpSlim::getInstance()->add($middleware);
}