<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 03/01/2018
 * Time: 16:38
 */

namespace App\Providers;


use Pimple\Container;
use Slim\Container as ContainerSlim;
use Pimple\ServiceProviderInterface;

class DatabaseProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['database-settings'] = function ($container) {
            return new ContainerSlim(require_once( __DIR__ . '/../../bootstrap/database.php' ));
        };
    }
}