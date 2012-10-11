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

    public function setArguments($arguments) {
        $this->routeObject->setArguments($arguments);
        return $this;
    }

    public function setOptions($options) {
        
        if(null !== $options['defaults']) {
            $options['defaults'] = $this->stringHelper->explodeString($options['defaults']); 
        }

        if(null !== $options['constraints']) {
            $options['constraints'] = $this->stringHelper->explodeString($options['constraints']);
        }
        
        $this->routeObject->setOptions($options);
    }

    public function buildRoute() {
        $config = $this->getProjectConfig();
       
        $writer = new \Zend\Config\Writer\PhpArray();
  
        foreach($config->router->routes as $name => $object) {
            if($this->routeObject->getModuleName() == $name) {
                throw new \Exception('I found a route with the same name.  Run `route:update` to modify this route.');
            }
        }

        $config->router->routes->merge($this->getRoute());
        $this->configHelper->newConfigToFile($config);
        var_dump($writer->toString($this->getRoute()));die();
        return $writer->toString($this->getRoute());
    }

    protected function getProjectConfig() {
        return $this->configHelper->getModuleConfig($this->routeObject->getProjectPath(), $this->routeObject->getModuleName());   
    }


    public function getRouteObject() {
        return $this->routeObject;
    }

    public function cleanUpMessage($message) {
       
        $message = substr($message, 12);
        $message = substr($message, 0, -2);
        return $message;
    }

    protected function getRoute() {
        
        $route = $this->configHelper->getConfigObject();
        $name  = $this->routeObject->getRouteName();
        $route->$name = array();
        $route->$name->type = $this->routeObject->getRouteType();
        $route->$name->options = $this->getRouteOptions();

        return $route;
    }

    protected function getRouteOptions() {
        
        $options = $this->configHelper->getConfigObject();

        $options->route = $this->routeObject->getRoute();
        $defaults = $this->routeObject->getRouteDefaults(); 
    
        if(null != $defaults) {
            $options->defaults = array();
            foreach($defaults as $k => $v) {
                $options->defaults->$k = $v;
            }
        }
        return $options;
    }


 
}
