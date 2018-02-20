<?php

namespace App\Modules\API\Http\Controller;

use App\UpSlim;
use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class HomeController
 * @package App\Modules\API\Http\Controller
 * @Controller
 */
class HomeController extends AbstractController
{
    /**
     * HomeController constructor.
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @Get(name="/", alias="route.HomeController")
     */
    public function indexAction(ServerRequestInterface $request, ResponseInterface $response) {
        echo "Up Slim " . UpSlim::getVersion();
    }
}