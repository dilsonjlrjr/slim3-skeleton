<?php

namespace App;

use Slim\App as SlimApp;


class UpSlim extends SlimApp
{

    /**
     * @var UpSlim
     */
    private static $application;

    /**
     * Current version
     *
     * @var string
     */
    const VERSION = '0.0.1';

    /**
     * @return UpSlim
     */
    public static function getInstance() {
        return self::$application;
    }

    /**
     * Set application slim
     * @param SlimApp $application
     */
    public static function setInstance(SlimApp $application) {
        self::$application = $application;
    }

    public static function getVersion() {
        return self::VERSION;
    }

}