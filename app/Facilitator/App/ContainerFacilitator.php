<?php

namespace App\Facilitator\App;

use App\UpSlim;
use Pimple\ServiceProviderInterface;
use Slim\Container;

class ContainerFacilitator
{

    /**
     * Get Container Slim
     * @return \Interop\Container\ContainerInterface|Container
     */
    public static function getContainer() {
        if (UpSlim::getInstance()->getContainer() == null) {
            return new Container();
        }
        return UpSlim::getInstance()->getContainer();
    }

    /**
     * Registry service manager
     * @param ServiceProviderInterface $serviceProvider
     */
    public static function register(ServiceProviderInterface $serviceProvider) {
        UpSlim::getInstance()->getContainer()->register($serviceProvider);
    }

    /**
     * @return array
     */
    public static function getSettingsContainer() {
        return ContainerFacilitator::getContainer()->get('settings');
    }
}