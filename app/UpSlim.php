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
        $listModules = include(self::getModulesList());
        $settings = ContainerFacilitator::getSettingsContainer();

        foreach ($listModules as $module) {
            Slim3Annotation::create(self::$application, [ $module::getControllers() ], $settings['dir_cache_controller']);
        }
    }

    public static function bootMiddlewares() {
        $middlewares = include(self::getMiddlewareList());

        foreach ($middlewares as $middleware) {
            self::$application->add($middleware);
        }
    }

    public static function bootServicesProviders() {
        $providers = include(self::getProvidersList());

        foreach ($providers as $provider) {
            ContainerFacilitator::register(new $provider);
        }
    }

    public static function getMiddlewareList() {
        $settings = ContainerFacilitator::getSettingsContainer();

        return $settings['path-config']['middleware']['list'];
    }

    public static function getMiddlewareInstall() {
        $settings = ContainerFacilitator::getSettingsContainer();

        return $settings['path-config']['middleware']['install'];
    }

    public static function getProvidersList() {
        $settings = ContainerFacilitator::getSettingsContainer();

        return $settings['path-config']['providers']['list'];
    }

    public static function getProvidersInstall() {
        $settings = ContainerFacilitator::getSettingsContainer();

        return $settings['path-config']['providers']['install'];
    }

    public static function getModulesList() {
        $settings = ContainerFacilitator::getSettingsContainer();

        return $settings['path-config']['modules']['list'];
    }

    public static function getModulesInstall() {
        $settings = ContainerFacilitator::getSettingsContainer();

        return $settings['path-config']['modules']['install'];
    }

}