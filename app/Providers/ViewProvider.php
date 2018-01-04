<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 03/01/2018
 * Time: 16:38
 */

namespace App\Providers;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ViewProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['view'] = function ($container) {
            $settings = $container->get('settings');
            $view = new Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

            return $view;
        };
    }
}