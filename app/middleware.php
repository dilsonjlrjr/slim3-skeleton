<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);

// -----------------------------------------------------------------------------
// Middleware Session
// -----------------------------------------------------------------------------
$settingsSession = $app->getContainer()->get('settings');
$settingsSession = $settingsSession['session'] ?: [];
$app->add(new \RKA\SessionMiddleware($settingsSession));
