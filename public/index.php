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

// -----------------------------------------------------------------------------
// Include settings in container
// -----------------------------------------------------------------------------
$container = $app->getContainer();
$container['database-settings'] = new \Slim\Collection(require __DIR__ . '/../app/database.php');

// -----------------------------------------------------------------------------
// Middleware Session
// -----------------------------------------------------------------------------
$settingsSession = $app->getContainer()->get('settings');
$settingsSession = $settingsSession['session'] ?: [];
$app->add(new \RKA\SessionMiddleware($settingsSession));

// -----------------------------------------------------------------------------
// Register middleware
// -----------------------------------------------------------------------------
require __DIR__ . '/../app/middleware.php';

// -----------------------------------------------------------------------------
// Set up dependencies
// -----------------------------------------------------------------------------
require __DIR__ . '/../app/dependencies.php';

// -----------------------------------------------------------------------------
// Register routes
// -----------------------------------------------------------------------------
$pathController = __DIR__ . '/../app/src/Controller';
\Slim3\Annotation\Slim3Annotation::create($app, $pathController, '');

//--------------------------------------------------------------------------
// Prepare Facilitator App Container
//--------------------------------------------------------------------------
\App\Facilitator\App\ContainerFacilitator::setApplication($app);

$settingsDatabase = $app->getContainer()->get('database-settings');
if ($settingsDatabase['boot-database']) {
    \App\Facilitator\Database\DatabaseFacilitator::getConnection();
}

// Run!
$app->run();
