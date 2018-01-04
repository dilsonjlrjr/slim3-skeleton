<?php

namespace App\Facilitator\Database\Drivers\Eloquent;

use App\Facilitator\App\ContainerFacilitator;
use Illuminate\Database\Capsule\Manager;


class Moloquent extends Allquent
{
    /**
     * Moloquent constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
    }

    function fabConnection()
    {
        return parent::fabConnection();
    }

    function createConnection()
    {
        parent::createConnection();
        self::$capsule->getDatabaseManager()->extend('mongodb', function($config) {
            return new \Moloquent\Connection($config);
        });

        return self::$capsule;
    }
}