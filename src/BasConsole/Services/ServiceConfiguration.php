<?php 
namespace BasConsole\Services;

use Zend\ServiceManager\Config,
    Symfony\Component\Console\Application,
    BasConsole\Factories,
    BasConsole\Commands,
    BasConsole\Objects;

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
                },
                
                'RouteCommand' => function($sm) {
                    $service = $sm->get('RouteService');
                    $command = new Commands\RouteCommand();
                    $command->setterInjector($service);
                    return $command;    
                },

                'RouteObject' => function($sm) {
                    $configHelper = $sm->get('ConfigHelper');
                    $stringHelper = $sm->get('StringHelper');
                    $routeObject = new Objects\RouteObject($configHelper, $stringHelper);
                    return $routeObject;    
                },

                'RouteService' => function($sm) {
                    $routeObject = $sm->get('RouteObject');
                    $service     = new RouteService($routeObject);
                    return $service;
                }
                
            ),

            'invokables' => array(
                'AppCommand'             => 'BasConsole\Commands\AppCommand',
                'BasModule'              => 'BasConsole\Module',
                'ConfigHelper'           => 'BasConsole\Helpers\ConfigHelper',
                'GreetCommand'           => 'BasConsole\Commands\GreetCommand',
                'ModuleCommand'          => 'BasConsole\Commands\ModuleCommand',
                'StringHelper'           => 'BasConsole\Helpers\StringHelper'
            )
        );
    }
}
