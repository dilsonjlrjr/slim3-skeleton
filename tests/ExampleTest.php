<?php

use Tests\BaseUnitTests;

/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 28/08/16
 * Time: 19:32
 */
class ExampleTest extends BaseUnitTests
{
    /**
     * @var \RKA\Session
     */
    protected $session;

    /**
     * @var \Doctrine\ODM\MongoDB\DocumentManager
     */
    protected $_dm;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function shouldInstanceObjectContainerInterface() {

        $this->_dm = $this->_ci->get('database');

        $this->assertInstanceOf(\Interop\Container\ContainerInterface::class, $this->_ci);
        $this->assertInstanceOf(\Doctrine\ODM\MongoDB\DocumentManager::class, $this->_dm);
    }

    /**
     * @test
     */
    public function shouldGetRootPath() {

        $response = $this->runRoute('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Slim Framework 3', (string)$response->getBody());
        $this->assertNotContains('Hello', (string)$response->getBody());

    }
}