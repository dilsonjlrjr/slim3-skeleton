<?php
/**
 * User: dilsonrabelo
 * Date: 26/08/16
 * Time: 20:40
 */

namespace App\Controller;


use Doctrine\ODM\MongoDB\DocumentManager;
use Interop\Container\ContainerInterface;
use RKA\Session;

abstract class AbstractController
{
    /**
     * @var DocumentManager
     */
    protected $_dm;

    /**
     * @var ContainerInterface $_ci
     */
    protected $_ci;

    /**
     * @var Session
     */
    private $session;

    /**
     * AbstractAction constructor.
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        $this->_ci = $ci;
        $this->_dm = $ci->get('database');
        $this->session = $this->_ci->get('session');
    }


}