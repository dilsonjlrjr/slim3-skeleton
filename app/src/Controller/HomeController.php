<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 26/08/16
 * Time: 21:16
 */

namespace App\Controller;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class HomeController
 * @package App\Controller
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
     * @Get(name="/")
     */
    public function indexAction(ServerRequestInterface $request, ResponseInterface $response) {
        echo "Slim Framework 3";
    }
}