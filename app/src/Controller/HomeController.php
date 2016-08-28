<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 26/08/16
 * Time: 21:16
 */

namespace App\Controller;

use Interop\Container\ContainerInterface;

class HomeController extends AbstractController
{
    /**
     * HomeAction constructor.
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        parent::__construct($ci);
    }

    public function indexAction() {
        echo "Slim Framework 3";
    }
}