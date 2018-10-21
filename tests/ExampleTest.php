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
    public function setUp()
    {
        parent::setUp();
    }


    /**
     * @test
     */
    public function shouldGetRootPath() {

        $response = $this->runRoute('GET', '/');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Up Slim 1.3.5', (string)$response->getBody());
        $this->assertNotContains('Hello', (string)$response->getBody());
    }
}