<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 05/01/2018
 * Time: 09:52
 */

namespace App\Console\Commands\Routing;


use App\Facilitator\App\ContainerFacilitator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class ControllerCreateCommand extends Command
{

    /**
     * @var string
     */
    protected $pathWriteModule;

    /**
     * @var string
     */
    protected $nameSpaceModule;

    /**
     * @var string
     */
    protected $nameController;

    /**
     * @var boolean
     */
    protected $stopProcess;

    /**
     * @var string
     */
    protected $verb;

    /**
     * @var InputInterface;
     */
    protected $input;

    /**
     * @var OutputInterface;
     */
    protected $output;


    protected function configure()
    {

        $this
            // the name of the command (the part after "bin/console")
            ->setName('up:create-controller')

            // the short description shown while running "php bin/console list"
            ->setDescription('Create controller')

            ->addArgument('name-module', InputArgument::REQUIRED, 'Name module is case-sensitive')

            ->addArgument('name-controller', InputArgument::REQUIRED, 'Name controller is case-sensitive');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setInputOutputInterface($input, $output)
            ->initializeAttributes()
            ->validateCommand()
            ->getVerb()
            ->writeController();
    }

    protected function setInputOutputInterface(InputInterface $input, OutputInterface $output) {

        $this->input = $input;
        $this->output = $output;

        return $this;
    }

    protected function initializeAttributes() {

        $arrayModule = $this->getModuleData($this->input->getArgument('name-module'));
        $this->nameController = $this->input->getArgument('name-controller') . 'Controller';

        if (count($arrayModule) != 0) {
            $this->pathWriteModule = $arrayModule['path-write-module'];
            $this->nameSpaceModule = $arrayModule['name-space-module'];
        }

        $this->stopProcess = false;
        return $this;
    }

    /**
     * @param $moduleName
     * @return mixed
     */
    protected function getModuleData($moduleName) {
        $container = ContainerFacilitator::getContainer();
        $settings = $container->get('settings');

        $arrayReturn = [];

        $listModules = require_once($settings['path-config']['modules']);
        foreach ($listModules as $module) {
            if (strtoupper($module::NAME) == strtoupper($moduleName)) {
                $arrayReturn['path-write-module'] = $module::getControllers();
                $arrayReturn['name-space-module'] = $module::getNamespace() . '\Http\Controller';
            }
        }

        return $arrayReturn;
    }

    protected function validateCommand() {
        $io = new SymfonyStyle($this->input, $this->output);

        if (!$this->pathWriteModule or !$this->nameSpaceModule) {
            $io->getErrorStyle()->error('Module not found');

            $this->stopProcess = true;
            return $this;
        }

        if (file_exists($this->pathWriteModule . '/' . $this->nameController . '.php')) {
            $this->stopProcess = true;
            $io->getErrorStyle()->error('Controller already exists');
            return $this;
        }

        return $this;
    }

    protected function getVerb() {

        if ($this->stopProcess)
            return $this;

        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            'Select verb route',
            [ 'Get', 'Post', 'Put', 'Delete', 'Options', 'Patch', 'Any' ]
        );
        $question->setErrorMessage('Verb %s is invalid.');

        $this->verb = $helper->ask($this->input, $this->output, $question);
        return $this;
    }


    protected function writeController() {

        if ($this->stopProcess)
            return false;

        $io = new SymfonyStyle($this->input, $this->output);
        $modelStub = file_get_contents(__DIR__ . '/stubs/controller.model.stubs');

        $modelStub = str_replace('{{CONTROLLER-NAME}}', $this->nameController, $modelStub);
        $modelStub = str_replace('{{NAMESPACE-CONTROLLER}}', $this->nameSpaceModule, $modelStub);
        $modelStub = str_replace('{{VERB-NAME}}', $this->verb, $modelStub);

        file_put_contents($this->pathWriteModule . '/' . $this->nameController . '.php', $modelStub);

        $io->success('Controller successfully created');

        return true;
    }
}