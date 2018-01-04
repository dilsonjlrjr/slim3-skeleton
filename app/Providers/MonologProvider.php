<?php

namespace App\Providers;

use Monolog\Logger;
use Pimple\ServiceProviderInterface;
use Pimple\Container;
use Monolog\Logger as LogMonolog;
use Monolog\Processor\UidProcessor;
use Monolog\Handler\StreamHandler;

class MonologProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['logger'] = function () use ($container) {
            $settings = $container['snake.settings'];
            $logger = new LogMonolog($settings['logger']['name']);
            $logger->pushProcessor(new UidProcessor());
            $logger->pushHandler(new StreamHandler($settings['logger']['path'], Logger::DEBUG));
            return $logger;
        };
    }
}