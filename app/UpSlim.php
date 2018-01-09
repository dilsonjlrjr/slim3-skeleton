<?php

namespace App;

use App\Facilitator\App\ContainerFacilitator;
use App\Facilitator\Database\DatabaseFacilitator;
use App\Providers\DatabaseProvider;
use Slim\App as SlimApp;
use Slim3\Annotation\Slim3Annotation;


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

    /**
     * @return string
     */
    public static function getVersion() {
        return self::VERSION;
    }

    /**
     * @throws \Exception
     */
    public static function bootDatabase() {
        ContainerFacilitator::getContainer()->register(new DatabaseProvider());
        DatabaseFacilitator::getConnection();
    }

    /**
     * @throws \Exception
     */
    public static function bootControllers() {
        $container = ContainerFacilitator::getContainer();
        $listModules = require_once(__DIR__ . '/../bootstrap/modules.php');
        $settings = $container->get('settings');

        foreach ($listModules as $module) {
            $moduleInstance = new $module();
            Slim3Annotation::create(self::$application, $moduleInstance->getControllers(), $settings['dir_cache_controller']);
        }

    }

    public static function bootMiddlewares() {
        $middlewares = require_once(__DIR__ . '/../bootstrap/middlewares.php');
        foreach ($middlewares as $middleware) {
            self::$application->add($middleware);
        }
    }

    public static function bootServicesProviders() {
        $providers = require_once(__DIR__ . '/../bootstrap/providers.php');
        foreach ($providers as $provider) {
            ContainerFacilitator::register(new $provider);
        }
    }

}