<?php

namespace App\Providers;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Slim\Flash\Messages;

class FlashMessagesProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['upslim.flash'] = function () use ($container) {
            return new Messages();
        };
    }
}