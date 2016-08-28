<?php
// Routes

$app->get('/', 'App\Controller\HomeController:indexAction')
    ->setName('homepage');