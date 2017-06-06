<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 06/06/17
 * Time: 11:50
 */

namespace App\Facilitator\Database\Drivers\PDO;

use App\Facilitator\App\ContainerFacilitator;
use App\Facilitator\Database\Drivers\IConnection;

class PDO implements IConnection
{

    /**
     * @var \PDO
     */
    protected static $pdoConnection;

    /**
     * @var array
     */
    private $connectionConfig;

    /**
     * PDO constructor.
     * @param $name
     */
    public function __construct($name)
    {
        $appContainer = ContainerFacilitator::getContainer();
        $databaseSettings = $appContainer->get('database-settings');
        $this->connectionConfig = $databaseSettings->get($name);
    }

    function fabConnection() : PDO
    {
        $user     = $this->connectionConfig['connection']['username'];
        $password = $this->connectionConfig['connection']['password'];
        $dsn = $this->connectionConfig['connection']['dsn'];


        $dbh = new PDO($dsn, $user, $password);
    }

    function createConnection() : PDO
    {
        return $this->fabConnection();
    }

    function getConnection()
    {
        throw new \Exception('Method not implemeted');
    }

}