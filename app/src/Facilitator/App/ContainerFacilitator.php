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
     * Get Container Slim
     * @return \Interop\Container\ContainerInterface|Container
     */
    public static function getContainer() {
        if (self::$application == null) {
            return new Container();
        }
        return self::$application->getContainer();
    }

    /**
     * Set application slim
     * @param App $application
     */
    public static function setApplication(App $application) {
        self::$application = $application;
    }
}