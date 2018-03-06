<?php
/**
 * Created by PhpStorm.
 * User: dilsonrabelo
 * Date: 02/03/2018
 * Time: 14:22
 */

namespace App\Console\Commands\Routing;


use App\UpSlim;
use Slim3\Annotation\CollectorRoute;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ListControllerCommand extends Command
{
    protected function configure()
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('up:list-controller')

            // the short description shown while running "php bin/console list"
            ->setDescription('List all controllers in API');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $table = new Table($output);
        $table->setHeaders([ 'MODULE', 'VERB', 'CLASS', 'METHOD', 'ROUTE', 'MIDDLEWARE' ]);

        $table->setRows(
            $this->getAPIControllers()
        );

        $table->render();
    }

    protected function getAPIControllers() {
        $arrayListModule = include_once(UpSlim::getModulesList());

        $arrayReturn = [];

        $collector = new CollectorRoute();
        foreach($arrayListModule as $module) {
            $pathController = $module::getControllers();

            ob_start();
            $arrayController = $collector->getControllers($pathController);
            $arrayRouteObject = $collector->castRoute($arrayController);

            foreach ($arrayRouteObject as $route) {
                $arrayMiddleware = $route->getClassMiddleware();

                $arrayReturnMiddleware = "";
                foreach ($arrayMiddleware as $middleware) {
                    $arrayReturnMiddleware .= $middleware . ", ";
                }

                $arrayReturnMiddleware = substr($arrayReturnMiddleware, 0, strlen($arrayReturnMiddleware) - 2);

                $arrayReturn[] = [ $module::NAME, $route->getVerb(), $route->getClassName(), $route->getMethodName(),  $route->getRoute(), $arrayReturnMiddleware ];
            }
        }

        return $arrayReturn;
    }

}