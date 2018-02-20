<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 20/02/2018
 * Time: 14:47
 */

namespace App\Console\Commands\Module;


use App\UpSlim;

class UtilsModuleCreateCommand
{

    /**
     * @var string
     */
    private $moduleInstall;

    /**
     * @var string
     */
    private $name;

    /**
     * UtilsModuleCreateCommand constructor.
     * @param $moduleInstall
     * @param $name
     */
    public function __construct($moduleInstall, $name)
    {
        $this->moduleInstall = $moduleInstall;
        $this->name = $name;
    }

    public function createDirectories() {
        mkdir($this->moduleInstall . '/' . $this->name);

        mkdir($this->moduleInstall . '/' . $this->name . '/Http/Controller', 0755, true);
        file_put_contents($this->moduleInstall . '/' . $this->name . '/Http/Controller/.keepme', '');

        mkdir($this->moduleInstall . '/' . $this->name . '/Http/Middleware',0755, true);
        file_put_contents($this->moduleInstall . '/' . $this->name . '/Http/Middleware/.keepme', '');

        mkdir($this->moduleInstall . '/' . $this->name . '/Model',0755, true);
        file_put_contents($this->moduleInstall . '/' . $this->name . '/Model/.keepme', '');

        mkdir($this->moduleInstall . '/' . $this->name . '/View', 0755, true);
        file_put_contents($this->moduleInstall . '/' . $this->name . '/View/.keepme', '');

        mkdir($this->moduleInstall . '/' . $this->name . '/Mapper',0755, true);
        file_put_contents($this->moduleInstall . '/' . $this->name . '/Mapper/.keepme', '');

        return true;
    }

    public function generateStub() {
        $modelStub = file_get_contents(__DIR__ . '/stubs/module.model.stubs');

        $modelStub = str_replace('{{NAMESPACE-MODULE}}', 'App\\Modules\\' . $this->name, $modelStub);
        $modelStub = str_replace('{{MODULE-NAME}}', $this->name, $modelStub);

        file_put_contents($this->moduleInstall . '/' . $this->name .  '/Module.php', $modelStub);

        $modelStub = file_get_contents(__DIR__ . '/stubs/abstractcontroller.model.stubs');

        $modelStub = str_replace('{{NAMESPACE-ABSTRACTCONTROLLER}}', 'App\\Modules\\' . $this->name . '\\Http\\Controller', $modelStub);

        file_put_contents($this->moduleInstall . '/' . $this->name .  '/Http/Controller/AbstractController.php', $modelStub);

        return 'App\\Modules\\' . $this->name;
    }

    public function publishModule($namespaceModule) {
        $allModules = include(UpSlim::getModulesList());

        $modulePublishWrite = "";
        foreach ($allModules as $module) {
            $modulePublishWrite .= "\t" . $module . "::class," . PHP_EOL;
        }

        $modulePublishWrite .= "\t" . $namespaceModule . "\Module::class,";

        $modelStub = file_get_contents(__DIR__ . '/stubs/modules.model.stubs');
        $modelStub = str_replace('{{LIST-MODULES}}', $modulePublishWrite, $modelStub);

        file_put_contents(UpSlim::getModulesList(), $modelStub);

    }

}