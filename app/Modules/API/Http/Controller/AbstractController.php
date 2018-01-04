<?php
/**
 * User: dilsonrabelo
 * Date: 26/08/16
 * Time: 20:40
 */

namespace App\Modules\API\Http\Controller;


use Doctrine\ODM\MongoDB\DocumentManager;
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