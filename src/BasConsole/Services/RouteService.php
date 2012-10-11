<?php
namespace BasConsole\Services;

use BasConsole\Objects,
    BasConsole\Helpers;

class RouteService {

    protected $routeObject;
    
    protected $configHelper;

    protected $stringHelper;

    public function __construct(Objects\RouteObject $routeObject, Helpers\ConfigHelper $configHelper, Helpers\StringHelper $stringHelper) {
        $this->routeObject  = $routeObject;
        $this->configHelper = $configHelper;
        $this->stringHelper = $stringHelper;
    }
    
    public function executeCommand() {
        return $this->cleanUpMessage($this->buildRoute());       
    }

    public function buildRoute() {
        $config = $this->getConfig();
        var_dump($config);die('config');
        $writer = new \Zend\Config\Writer\PhpArray();
  
        foreach($config->router->routes as $name => $object) {
            if($this->moduleName == $name) {
                throw new \Exception('I found a route with the same name.  Run `route:update` to modify this route.');
            }
        }

        $config->router->routes->merge($this->getRoute());
        //$this->configHelper->newConfigToFile($config);
        return $writer->toString($this->getRoute());
    }

    protected function getConfig() {
        return $this->configHelper->getModuleConfig($this->projectPath, $this->moduleName);   
    }


    public function getRouteObject() {
        return $this->routeObject;
    }

    public function cleanUpMessage($message) {
       
        $message = substr($message, 12);
        $message = substr($message, 0, -2);
        return $message;
    }
 
}
