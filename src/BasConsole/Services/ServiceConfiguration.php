<?php 
namespace BasConsole\Services;

use Zend\ServiceManager\Config,
    Symfony\Component\Console\Application,
    BasConsole\Factories;

class ServiceConfiguration extends Config {

    public function __construct() {
        parent::__construct($this->configServiceManager());
    }
    
    public function configServiceManager() {
        return array(
            'aliases' => array(
                'Symfony\Component\Console\Application' => 'ConsoleApp',
                'BasConsole\Module'                     => 'BasModule',
            ),
            'factories' => array(
                'ConsoleApp' => function($sm) {
                    $factory  = $sm->get('ConsoleCommandsFactory'); 
                    $app      = new Application();
                    $app->addCommands($factory->getCommands());
                    return $app;
                },
                'ConsoleCommandsFactory' => function($sm) {
                    $module = $sm->get('BasModule');
                    $factory = new Factories\ConsoleCommandsFactory($sm, $module->getConfig());
                    return $factory;
                }
            ),

            'invokables' => array(
                'AppCommand'             => 'BasConsole\Commands\AppCommand',
                'BasModule'              => 'BasConsole\Module',
                'GreetCommand'           => 'BasConsole\Commands\GreetCommand',
                'ModuleCommand'          => 'BasConsole\Commands\ModuleCommand',
                'RouteCommand'           => 'BasConsole\Commands\RouteCommand',
            )
        );
    }
}
