<?php

namespace App\Facilitator\Database\Drivers;

use App\Facilitator\App\ContainerFacilitator;
use Illuminate\Database\Capsule\Manager;


class Moloquent
{
    /**
     * @return Manager
     */
    function __invoke() : Manager
    {
        $appContainer = ContainerFacilitator::getContainer();
        $databaseSettings = $appContainer->get('database-settings');
        $settings = $databaseSettings->get($databaseSettings->get('driver'));

        $capsule = new Manager();
        $capsule->addConnection($settings['connection']);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $capsule->getDatabaseManager()->extend('mongodb', function($config) {
            return new \Moloquent\Connection($config);
        });

        return $capsule;
    }
}