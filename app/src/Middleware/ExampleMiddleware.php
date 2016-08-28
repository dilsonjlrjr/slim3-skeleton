<?php

namespace App\Middleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 25/08/16
 * Time: 15:10
 */
class ExampleMiddleware
{

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     *
     * @return ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $response->getBody()->write("AFTER");
        $response = $next($request, $response);
        $response->getBody()->write("BEFORE");

        return $response;
    }

}