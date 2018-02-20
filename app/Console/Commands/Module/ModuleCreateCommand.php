<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 19/02/2018
 * Time: 10:49
 */

namespace App\Console\Commands\Module;


use App\UpSlim;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class ModuleCreateCommand extends Command
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var InputInterface;
     */
    protected $input;

    /**
     * @var OutputInterface;
     */
    protected $output;

    /**
     * @var boolean
     */
    protected $stopProcess;

    /**
     * @var string
     */
    protected $moduleInstall;

    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('up:create-module')

            // the short description shown while running "php bin/console list"
            ->setDescription('Create module')

            ->addArgument('name-module', InputArgument::REQUIRED, 'Name module is case-sensitive');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->setInputOutputInterface($input, $output)
            ->initializeAttributes()
            ->validateCommand()
            ->writeModule();
    }

    protected function setInputOutputInterface(InputInterface $input, OutputInterface $output) {

        $this->input = $input;
        $this->output = $output;

        return $this;
    }

    protected function initializeAttributes() {

        $this->name = $this->input->getArgument('name-module');

        $this->moduleInstall = UpSlim::getModulesInstall();

        return $this;
    }

    protected function validateCommand() {
        $io = new SymfonyStyle($this->input, $this->output);

        if (is_dir($this->moduleInstall . '/' . $this->name)) {
            $io->getErrorStyle()->error('Module already exists!');
            $this->stopProcess = true;
            return $this;
        }

        return $this;
    }

    protected function writeModule() {

        if ($this->stopProcess)
            return false;

        $utils = new UtilsModuleCreateCommand($this->moduleInstall, $this->name);

        $utils->createDirectories();

        $namespaceModule = $utils->generateStub();

        $utils->publishModule($namespaceModule);

        $utils = null;

        $io = new SymfonyStyle($this->input, $this->output);
        $io->success('Module successfully created');

        $this->createInitialController();

        return true;
    }

    private function createInitialController() {
        $command = $this->getApplication()->find('up:create-controller');

        $arguments = [
            'command' => 'up:create-controller',
            'name-module' => $this->name,
            'name-controller' => 'NewController',
            'verb' => 'Get'
        ];

        $input = new ArrayInput($arguments);
        $command->run($input,$this->output);

        return true;
    }

}