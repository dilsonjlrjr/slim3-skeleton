<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 26/02/2018
 * Time: 10:44
 */

namespace App\Console\Commands\Routing;


use App\UpSlim;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MethodControllerCommand extends Command
{

    /**
     * @var InputInterface
     */
    private $input;

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * @var string
     */
    private $nameModule;

    /**
     * @var \stdClass
     */
    private $metaModule;

    /**
     * @var string
     */
    private $nameController;

    /**
     * @var string
     */
    private $pathController;

    /**
     * @var string
     */
    private $nameMethod;

    /**
     * @var \ReflectionClass
     */
    private $reflectionClass;

    /**
     * @var string
     */
    private $verb;

    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    protected $pathFullController;

    /**
     * @var boolean
     */
    protected $stopProcess;

    protected function configure()
    {
        $this->stopProcess = false;

        $this
            // the name of the command (the part after "bin/console")
            ->setName('up:create-method-controller')

            // the short description shown while running "php bin/console list"
            ->setDescription('Create Method in Controller')

            ->addArgument('name-module', InputArgument::REQUIRED, 'Name module is case-sensitive')

            ->addArgument('name-controller', InputArgument::REQUIRED, 'Name controller is case-sensitive')

            ->addArgument('name-method', InputArgument::REQUIRED, 'Name method is case-sensitive')

            ->addArgument('route', InputArgument::REQUIRED,
                'Route eg.: /route, /route/:id more information: https://github.com/dilsonjlrjr/slim3-annotation');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setInputOutputInterface($input, $output)
            ->initializeAttributes()
            ->validateAllElements()
            ->writeMethod();

    }

    protected function setInputOutputInterface(InputInterface $input, OutputInterface $output) {

        $this->input = $input;
        $this->output = $output;

        return $this;
    }

    protected function initializeAttributes() {

        $this->nameModule = $this->input->getArgument('name-module');
        $this->nameController = ucwords(strtolower($this->input->getArgument('name-controller')));
        $this->nameMethod = $this->input->getArgument('name-method');
        $this->verb = 'Get';
        $this->route = strtolower($this->input->getArgument('route'));

        return $this;
    }

    private function validateAllElements() {
        $io = new SymfonyStyle($this->input, $this->output);

        if (!$this->validateModule()) {
            $io->error('Module already exists');
            $this->stopProcess = true;
            return $this;
        }

        if (!$this->createReflactionClass()) {
            $io->error('Controller not found');
            $this->stopProcess = true;
            return $this;
        }

        if (!$this->validateController()) {
            $io->error('Controller not exists');
            $this->stopProcess = true;
            return $this;
        }

        if ($this->validateMethod()) {
            $io->error('Method already exists');
            $this->stopProcess = true;
            return $this;
        }

        return $this;
    }

    private function createReflactionClass() {
        try {
            $this->reflectionClass = new \ReflectionClass($this->metaModule::getNameSpace() . '\\Http\\Controller\\' . $this->nameController);
        } catch(\Exception $exception) {
            return false;
        }

        return true;
    }

    private function validateModule() {
        $listModules = include(UpSlim::getModulesList());

        $bModuleFounded = false;

        foreach ($listModules as $module) {
            if (strtoupper($module::NAME) == strtoupper($this->nameModule)) {
                $this->pathController = $module::getControllers();
                $this->metaModule = $module;
                $bModuleFounded = true;
                break;
            }
        }

        return $bModuleFounded;
    }

    private function validateController() {
        $this->pathFullController = $this->pathController . '/' . $this->nameController . '.php';

        if (file_exists($this->pathFullController))
            return true;

        return false;
    }

    private function validateMethod() {

        $allMethodsClass = $this->reflectionClass->getMethods();

        $bMethodFounded = false;

        foreach ($allMethodsClass as $method) {
            if ($method->getName() == $this->nameMethod){
                $bMethodFounded = true;
                break;
            }
        }

        return $bMethodFounded;

    }

    private function writeMethod() {

        if (!$this->stopProcess) {

            $fileGetContents = file_get_contents($this->pathFullController);

            $lastPosition = strrpos($fileGetContents, '}');

            $informationArray = [];

            for ($ilaco = $lastPosition; $ilaco < strlen($fileGetContents); $ilaco++ ) {
                $informationArray[] = $fileGetContents[$ilaco];
            }

            $fileGetContents[$lastPosition] = "\n";

            $lastPosition++;

            $message = str_split($this->createStub());


            foreach($message as $key => $value) {
                $fileGetContents[$lastPosition + $key] = $value;
            }

            $lastPosition += count($message);

            foreach($informationArray as $key => $value) {
                $fileGetContents[$lastPosition + $key] = $value;
            }

            file_put_contents($this->pathFullController, $fileGetContents);

            $io = new SymfonyStyle($this->input, $this->output);
            $io->success('Method successfully created');
        }

        return true;
    }

    private function createStub() {
        $fileStub = file_get_contents(__DIR__ . '/stubs/method.model.stubs');

        $fileStub = str_replace('{{VERB}}', $this->verb, $fileStub);
        $fileStub = str_replace('{{ROUTE}}', $this->route, $fileStub);
        $fileStub = str_replace('{{METHOD-NAME}}', $this->nameMethod, $fileStub);

        return $fileStub;
    }


}