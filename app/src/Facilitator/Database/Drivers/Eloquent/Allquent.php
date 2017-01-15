<?php


namespace App\Facilitator\Database\Drivers\Eloquent;


use App\Facilitator\App\ContainerFacilitator;
use App\Facilitator\Database\Drivers\IConnection;
use Illuminate\Database\Capsule\Manager;

class Allquent implements IConnection
{
    /**
     * @var Manager
     */
    protected static $capsule;

    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $connectionConfig;

    /**
     * Allquent constructor.
     * @param string $name
     */
    public function __construct($name)
    {
        if (!self::$capsule instanceof Manager) {
            self::$capsule = new Manager();
        }
        $appContainer = ContainerFacilitator::getContainer();
        $databaseSettings = $appContainer->get('database-settings');
        $this->connectionConfig = $databaseSettings->get($name);
        $this->name = $name;
    }


    function fabConnection()
    {
        self::$capsule->addConnection($this->connectionConfig, $this->name);
        return self::getConnection();
    }

    function getConnection()
    {
        return self::$capsule;
    }

    function createConnection() {
        $this->fabConnection();

        self::$capsule->setAsGlobal();
        self::$capsule->bootEloquent();

        return self::getConnection();
    }

}