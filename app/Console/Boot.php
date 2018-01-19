<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 19/01/2018
 * Time: 14:09
 */

namespace App\Console;


use App\Console\Commands\Routing\ControllerCreateCommand;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class Boot
{
    private static $commandList = [
        ControllerCreateCommand::class
    ];

    /**
     * @var Application
     */
    private static $application;

    /**
     * @param Application $application
     */
    public static function setApplication(Application $application)
    {
        self::$application = $application;
    }

    public static function bootCommand() {
        foreach (self::$commandList as $command) {
            self::$application->add(new $command);
        }
    }

    public static function registryCommand(Command $command) {
        self::$commandList[] = $command;
    }
}