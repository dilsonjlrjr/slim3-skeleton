<?php

namespace App\Providers;

use Pimple\ServiceProviderInterface;
use Pimple\Container;


class ErrorHandlerProvider implements ServiceProviderInterface
{
    public function register(Container $container)
    {
        $container['errorHandler'] = function () use ($container) {
            return function ($request, $response, $exception) use ($container) {
                $arrayJson = [ "code" => $exception->getCode(), "message" => 'Something went wrong! Cause: ' . $exception->getMessage()];

                return $container['response']->withStatus(500)
                    ->withHeader('Content-Type', 'text/html')
                    ->withJson($arrayJson);
            };
        };

        $container['phpErrorHandler'] = function () use ($container) {
            return function ($request, $response, $exception) use ($container) {
                $arrayJson = [ "code" => $exception->getCode(), "message" => 'Something went wrong! Cause: ' . $exception->getMessage()];

                return $container['response']->withStatus(500)
                    ->withHeader('Content-Type', 'text/html')
                    ->withJson($arrayJson);
            };
        };
    }
}