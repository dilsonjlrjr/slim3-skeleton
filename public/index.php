<?php

// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__ . '/../vendor/autoload.php';

// Instantiate the app
$settings = require __DIR__ . '/../app/settings.php';
$app = new \Slim\App($settings);

/*
|--------------------------------------------------------------------------
| Include settings in container
|--------------------------------------------------------------------------
*/
$container = $app->getContainer();
$container['database-settings'] = new \Slim\Collection(require __DIR__ . '/../app/database.php');

// Set up dependencies
require __DIR__ . '/../app/dependencies.php';

// Register middleware
require __DIR__ . '/../app/middleware.php';

// Register routes
require __DIR__ . '/../app/routes.php';

/*
|--------------------------------------------------------------------------
| Prepare Facilitator App Container
|--------------------------------------------------------------------------
*/
\App\Facilitator\App\ContainerFacilitator::setApplication($app);

// Run!
$app->run();
