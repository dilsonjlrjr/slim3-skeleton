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
     * Name application
     *
     * @var string
     */
    const NAME = 'UPSlim';

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

    public static function getName() {
        return self::NAME;
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
        $settings = $container->get('settings');

        $listModules = require_once($settings['path-config']['modules']);
        foreach ($listModules as $module) {
            Slim3Annotation::create(self::$application, [ $module::getControllers() ], $settings['dir_cache_controller']);
        }

    }

    public static function bootMiddlewares() {
        $container = ContainerFacilitator::getContainer();
        $settings = $container->get('settings');

        $middlewares = require_once($settings['path-config']['middleware']);
        foreach ($middlewares as $middleware) {
            self::$application->add($middleware);
        }
    }

    public static function bootServicesProviders() {
        $container = ContainerFacilitator::getContainer();
        $settings = $container->get('settings');

        $providers = require_once($settings['path-config']['providers']);
        foreach ($providers as $provider) {
            ContainerFacilitator::register(new $provider);
        }
    }

}