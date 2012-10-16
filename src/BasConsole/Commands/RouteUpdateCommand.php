<?php 
namespace BasConsole\Commands;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    BasConsole\Services;

class RouteUpdateCommand extends Command 
{
    protected $routeService; 
    
    protected function configure()
    {   
        $this->setName('route:update')->setDescription($this->getDescript())
             ->addArgument('{RouteName}', InputArgument::REQUIRED, 'The Currently Used Route Name.')
             ->addOption('name', null, InputOption::VALUE_REQUIRED, 'Use this option to update the Route Name')
             ->addOption('route', null, InputOption::VALUE_REQUIRED, 'The actual route to update e.g. /Demo/Album/testing')
             ->addOption('parent', null, InputOption::VALUE_REQUIRED, 'If Updating a Child Route use this to give the parent route name.')
             ->addOption('terminate', null, InputOption::VALUE_REQUIRED, 'Update the `may_terminate` option.')
             ->addOption('type', null, InputOption::VALUE_REQUIRED, 'Update your Route Type.')
             ->addOption('module', null, InputOption::VALUE_REQUIRED, 'The Module to add this Route to.', 'Application')
             ->addOption('defaults', null, InputOption::VALUE_REQUIRED, 'Update Defaults for this route.')
             ->addOption('constraints', null, InputOption::VALUE_REQUIRED, 'Update Constraints for this route.')
             ->addOption('path', null, InputOption::VALUE_REQUIRED, 'A path to use, if not already in the root project directory');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
         
        $this->routeService->configureRouteObject($input->getArguments(), $input->getOptions());
       
        $message = $this->routeService->executeCommand();
         
        $output->writeln("<info>Route Updated to -- {$this->routeService->getRouteObject()->getModuleName()} Module Config File --</info>");
        $output->writeln("<comment>{$message}</comment>");
    }

    private function getDescript() {
        return 'Update any option used for adding a Route (To Completly Remove an option type --option="remove" (Some options cannot be removed)';

    }

    public function setterInjector(Services\RouteService $routeService) {
        $this->routeService = $routeService;    
    }

}
