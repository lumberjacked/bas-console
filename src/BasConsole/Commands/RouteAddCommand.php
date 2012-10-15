<?php 
namespace BasConsole\Commands;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    BasConsole\Services;

class RouteAddCommand extends Command 
{
    protected $routeService; 
    
    protected function configure()
    {   
        $this->setName('route:add')->setDescription($this->getDescript())
             ->addArgument('{RouteName}', InputArgument::REQUIRED, 'The name used for this route.')
             ->addArgument('{Route}', InputArgument::REQUIRED, 'The actual route e.g. /Demo/Album/testing')
             ->addOption('parent', null, InputOption::VALUE_REQUIRED, 'Make this a child route with the Parent Route Name.')
             ->addOption('type', null, InputOption::VALUE_REQUIRED, 'Route Type!', 'Segment')
             ->addOption('module', null, InputOption::VALUE_REQUIRED, 'The Module to add this Route to.', 'Application')
             ->addOption('defaults', null, InputOption::VALUE_REQUIRED, 'Defaults for this route.')
             ->addOption('constraints', null, InputOption::VALUE_REQUIRED, 'Constraints for this route.')
             ->addOption('path', null, InputOption::VALUE_REQUIRED, 'A path to use, if not already in the root project directory');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
         
        $this->routeService->configureRouteObject($input->getArguments(), $input->getOptions());
       
        $message = $this->routeService->executeCommand();
         
        $output->writeln("<info>Route Added to -- {$this->routeService->getRouteObject()->getModuleName()} Module Config File --</info>");
        $output->writeln("<comment>{$message}</comment>");
    }

    private function getDescript() {
        return 'Add a Route to your Project (Segment Default -(Routes are case - insensitive)';

    }

    public function setterInjector(Services\RouteService $routeService) {
        $this->routeService = $routeService;    
    }

}
