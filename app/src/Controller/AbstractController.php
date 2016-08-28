<?php
/**
 * User: dilsonrabelo
 * Date: 26/08/16
 * Time: 20:40
 */

namespace App\Controller;


use Doctrine\ODM\MongoDB\DocumentManager;
use Interop\Container\ContainerInterface;

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
     * AbstractAction constructor.
     * @param ContainerInterface $ci
     */
    public function __construct(ContainerInterface $ci)
    {
        $this->_ci = $ci;
        $this->_dm = $ci->get('_dm');
    }


}