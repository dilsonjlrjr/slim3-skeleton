<?php

namespace Tests;

use App\Facilitator\App\ContainerFacilitator;
use Slim\Collection;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim3\Annotation\Slim3Annotation;

use PHPUnit\Framework\TestCase;

/**
 * Class BaseTests
 */
class BaseUnitTests extends TestCase
{
    /**
     * @var \Slim\App
     */
    private $_app;

    /**
     * Setup Tests
     */
    public function setUp()
    {
        $this->createApplication();
    }

    /**
     * Create Application
     *
     * @return bool
     */
    private function createApplication() {

        if (!$this->_app instanceof \Slim\App) {
            require __DIR__ . '/../bootstrap/boot.php';
            $this->_app = $app;
        }        

        return TRUE;
    }

    /**
     * Process the application given a request method and URI
     *
     * @param string $requestMethod the request method (e.g. GET, POST, etc.)
     * @param string $requestUri the request URI
     * @param array|object|null $requestData the request data
     * @return \Slim\Http\Response
     */
    public function runRoute($requestMethod, $requestUri, $requestData = null)
    {
        // Create a mock environment for testing with
        $environment = Environment::mock(
            [
                'REQUEST_METHOD' => $requestMethod,
                'REQUEST_URI' => $requestUri
            ]
        );

        // Set up a request object based on the environment
        $request = Request::createFromEnvironment($environment);

        // Add request data, if it exists
        if (isset($requestData)) {
            $request = $request->withParsedBody($requestData);
        }

        // Set up a response object
        $response = new Response();

        // Process the application
        $response = $this->_app->process($request, $response);

        // Return the response
        return $response;
    }

    // public function tearDown() {
    //     $this->_app = null;
    // }
}