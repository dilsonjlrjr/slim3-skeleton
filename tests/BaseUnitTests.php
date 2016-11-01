<?php

namespace Tests;

use App\Facilitator\App\ContainerFacilitator;
use Slim\Collection;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim3\Annotation\Slim3Annotation;

/**
 * Class BaseTests
 */
class BaseUnitTests extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Interop\Container\ContainerInterface
     */
    protected $_ci;

    /**
     * @var Slim\App
     */
    protected $_app;

    /**
     * Setup Tests
     */
    public function setUp()
    {
        @session_start();
        $this->createApplication();
    }

    /**
     * Create Application
     *
     * @return bool
     */
    private function createApplication() {

        // Instantiate the app
        $settings = require __DIR__ . '/../app/settings.php';
        $app = new \Slim\App($settings);

        $container = $app->getContainer();
        $container['database-settings'] = new Collection(require __DIR__ . '/../app/database.php');

        // -----------------------------------------------------------------------------
        // Set up dependencies
        // -----------------------------------------------------------------------------
        require __DIR__ . '/../app/dependencies.php';

        // -----------------------------------------------------------------------------
        // Middleware Session
        // -----------------------------------------------------------------------------
        $settingsSession = $app->getContainer()->get('settings');
        $settingsSession = $settingsSession['session'] ?: [];
        $app->add(new \RKA\SessionMiddleware($settingsSession));

        // -----------------------------------------------------------------------------
        // Register middleware
        // -----------------------------------------------------------------------------
        require __DIR__ . '/../app/middleware.php';

        $settingsDatabase = $app->getContainer()->get('database-settings');
        if ($settingsDatabase['boot-database']) {
            \App\Facilitator\Database\DatabaseFacilitator::getConnection();
        }

        // -----------------------------------------------------------------------------
        // Register routes
        // -----------------------------------------------------------------------------
        $pathController = __DIR__ . '/../app/src/Controller';
        Slim3Annotation::create($app, $pathController, '');

        ContainerFacilitator::setApplication($app);
        $this->_app = $app;
        $this->_ci = $container;

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
}