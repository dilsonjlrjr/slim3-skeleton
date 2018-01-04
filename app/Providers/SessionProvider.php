<?php

namespace App\Providers;

use Pimple\ServiceProviderInterface;
use Pimple\Container;
use RKA\Session as RKASession;

class SessionProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['upslim.session'] = function () use ($container) {
            return new RKASession();
        };
    }
}