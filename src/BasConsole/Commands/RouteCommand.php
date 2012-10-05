<?php 
namespace BasConsole\Commands;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface,
    BasConsole\Services\RouteService;

class RouteCommand extends Command 
{
    protected $routeService; 
    
    protected function configure()
    {   
        $this->setName('route:add')->setDescription($this->getDescript())
             ->addArgument('{RouteName}', InputArgument::REQUIRED, 'Choose a name for this route.')
             ->addArgument('{Route}', InputArgument::REQUIRED, 'Choose the actual route ex. /Demo/Album/testing')
             ->addOption('type', null, InputOption::VALUE_REQUIRED, 'Choose a Route Type!', 'Segment')
             ->addOption('module', null, InputOption::VALUE_REQUIRED, 'Choose the Module to add this Route to', 'Application')
             ->addOption('defaults', null, InputOption::VALUE_REQUIRED, 'Choose Defaults for this route.')
             ->addOption('path', null, InputOption::VALUE_REQUIRED, 'Choose a path to use, if not already in the root project directory');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
         
        $routeObject =$this->routeService->getRouteObject();
        $routeObject->setArguments($input->getArguments())->setOptions($input->getOptions());
        $this->routeService->executeCommand();


    }

    private function getDescript() {
        return 'Add a Route to your Project (Segment Default -(Routes are case - insensitive)';

    }

    public function setterInjector(RouteService $routeService) {
        $this->routeService = $routeService;
    }

}
