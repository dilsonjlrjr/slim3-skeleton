<?php

use Tests\BaseTests;

/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 28/08/16
 * Time: 19:32
 */
class ExampleTest extends BaseTests
{

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function shouldInstanceObjectContainerInterface() {

        $this->assertInstanceOf(\Interop\Container\ContainerInterface::class, $this->_ci);

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