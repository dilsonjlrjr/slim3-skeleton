<?php

namespace App\Modules\API\Http\Controller;


use Interop\Container\ContainerInterface;
use RKA\Session;

abstract class AbstractController
{

    /**
     * @var ContainerInterface $_ci
     */
    protected $_ci;

    /**
     * AbstractAction constructor.
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        $this->_ci = $ci;
    }


}