<?php 
namespace BasConsole\Services;

use Zend\ServiceManager\Config,
    Zend\Config\Config as ConfigWriter,
    Symfony\Component\Console\Application,
    BasConsole\Factories,
    BasConsole\Commands,
    BasConsole\Helpers,
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
                'Zend\Config\Config'                    => 'ConfigWriter'
            ),
            'factories' => array(
                'ConfigHelper' => function($sm) {
                    $factory = $sm->get('ConfigFactory');
                    $config  = new Helpers\ConfigHelper($factory);
                    return $config;
                },
                'ConfigWriter' => function($sm) {
                    $writer = new ConfigWriter(array());
                    return $writer;
                },
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
                    $routeObject = $sm->get('RouteObject');
                    $command = new Commands\RouteCommand();
                    $command->setterInjector($routeObject);
                    return $command;    
                },

                'RouteObject' => function($sm) {
                    $routeService = $sm->get('RouteService');
                    $routeObject = new Objects\RouteObject($routeService);
                    return $routeObject;    
                },

                'RouteService' => function($sm) {
                    $configHelper = $sm->get('ConfigHelper');
                    $stringHelper = $sm->get('StringHelper');
                    $service     = new RouteService($configHelper, $stringHelper);
                    return $service;
                }
                
            ),

            'invokables' => array(
                'AppCommand'             => 'BasConsole\Commands\AppCommand',
                'BasModule'              => 'BasConsole\Module',
                'ConfigFactory'          => 'BasConsole\Factories\ConfigFactory',
                'GreetCommand'           => 'BasConsole\Commands\GreetCommand',
                'ModuleCommand'          => 'BasConsole\Commands\ModuleCommand',
                'StringHelper'           => 'BasConsole\Helpers\StringHelper'
            )
        );
    }
}
