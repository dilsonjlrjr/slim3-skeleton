<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 26/08/16
 * Time: 21:16
 */

namespace App\Controller;

use App\Mapper\UserDoctrineODM;
use App\Mapper\UserMoloquent;
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

        // -----------------------------------------------------------------------------
        // Example Doctrine
        // -----------------------------------------------------------------------------
        //$user = $this->_databaseManager->getRepository(UserDoctrineODM::class)->findAll();
        //echo $user[0]->username;

        // -----------------------------------------------------------------------------
        // Example Moloquent
        // -----------------------------------------------------------------------------
        //$user = UserMoloquent::all();
        //echo $user[0]->getUsername();

        echo "Slim framework 3 - Slim Skeleton";
    }
}