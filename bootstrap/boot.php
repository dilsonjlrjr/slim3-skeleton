<?php


// -----------------------------------------------------------------------------
// To help the built-in PHP dev server, check if the request was actually for
// something which should probably be served as a static file
// -----------------------------------------------------------------------------
if (PHP_SAPI === 'cli-server' && $_SERVER['SCRIPT_FILENAME'] !== __FILE__) {
    return false;
}

require __DIR__ . '/../vendor/autoload.php';

// -----------------------------------------------------------------------------
// Instantiate the app
// -----------------------------------------------------------------------------
if (!file_exists(__DIR__ . '/settings.php'))
    throw new \Exception('File settings not exists. Create one in the bootstrap folder at the root of your project.');

$settings = require_once(__DIR__ . '/settings.php');
$app = new \App\UpSlim($settings);
\App\UpSlim::setInstance($app);


// -----------------------------------------------------------------------------
// Boot Modules
// -----------------------------------------------------------------------------
\App\UpSlim::bootControllers();

//--------------------------------------------------------------------------
// Register Providers
//--------------------------------------------------------------------------
\App\UpSlim::bootServicesProviders();

//--------------------------------------------------------------------------
// Register Middlewares
//--------------------------------------------------------------------------
\App\UpSlim::bootMiddlewares();

//--------------------------------------------------------------------------
// Boot Database
//--------------------------------------------------------------------------
//\App\UpSlim::bootDatabase();