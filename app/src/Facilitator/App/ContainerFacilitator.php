<?php

namespace App\Facilitator\App;

use Slim\App;
use Slim\Container;

class ContainerFacilitator
{
    /**
     * @var App
     */
    private static $application;

    /**
     * @return \Interop\Container\ContainerInterface|Container
     */
    public static function getContainer() {
        if (self::$application == null) {
            return new Container();
        }
        return self::$application->getContainer();
    }

    public static function setApplication(App $application) {
        self::$application = $application;
    }
}