<?php 
namespace BasConsole\Services;

use Zend\ServiceManager\Config;

class ServiceConfiguration extends Config {

    public function __construct() {
        parent::__construct($this->configServiceManager());
    }
    
    public function configServiceManager() {
        return array(
            'aliases' => array(
                'Symfony\Component\Console\Application' => 'ConsoleApp',
            ),
            'factories' => array(
                'ConsoleApp' => function($sm) {
                    $commands = new ConsoleCommands();
                    $app      = new ConsoleApp($commands->getCommands());
                }
            ),

            'invokables' => array(
                'AppCommand'      => 'BasConsole\Commands\AppCommand',
                'ConsoleCommands' => 'BasConsole\Services\ConsoleCommands',
                'GreetCommand'    => 'BasConsole\Commands\GreetCommand',
                'ModuleCommand'   => 'BasConsole\Commands\ModuleCommand',
                'RouteCommand'    => 'BasConsole\Commands\RouteCommand',
            )
        );
    }
}
