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

    public function __construct(RouteService $routeService) {
        $this->routeService = $routeService;
    }
    
    protected function configure()
    {   
        $this->setName('route:add')->setDescription($this->getDescript())
             ->addArgument('{RouteName}', InputArgument::REQUIRED, 'Choose a name for this route.')
             ->addOption('type', null, InputOption::VALUE_REQUIRED, 'Choose a Route Type!', 'Segment')
             ->addOption('module', null, InputOption::VALUE_REQUIRED, 'Choose the Module to add this Route to');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        
        $this->routeService->setRouteName($input->getArgument('{RouteName}'));
        $this->routeService->setRouteType($input->getOption('type'));
        $this->routeService->setRouteModule($input->getOption('module'));

        $message = $this->routeService->executeCommand();


    }

    private function getDescript() {
        return 'Add a Route to your Project (Segment Default -(Routes are case - insensitive)';

    }

}
