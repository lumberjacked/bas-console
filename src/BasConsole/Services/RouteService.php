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

    public function setDefaultType($type = null) {
        $this->routeObject->setDefaultType($type);
        return $this;
    }

    public function configureRouteObject(array $configuration) {
         
        if(array_key_exists('defaults', $configuration)) {
            $configuration['defaults'] = $this->stringHelper->explodeString($configuration['defaults']); 
        }

        if(array_key_exists('constraints', $configuration)) {
            $configuration['constraints'] = $this->stringHelper->explodeString($configuration['constraints']);
        }
       
        $this->routeObject->configureObject($configuration);
    }

    public function buildRoute() {
        $config = $this->getProjectConfig();
       
        $writer = new \Zend\Config\Writer\PhpArray();
  
        foreach($config->router->routes as $name => $object) {
            if($this->routeObject->getModuleName() == $name) {
                throw new \Exception('I found a route with the same name.  Run `route:update` to modify this route.');
            }
        }
        
        $routes = $this->mergeRoute($config->router->routes);
       
        $config->router->routes->merge($routes);
        $this->configHelper->newConfigToFile($config);
       
        return $writer->toString($this->getRoute());
    }

    protected function mergeRoute($routes) {
        $parent = $this->routeObject->getParent();
        

        if(null != $parent) {
            $this->recursiveAddChild($routes, $parent);
                         
        } else {
            $routes->merge($this->getRoute());

        }
        return $routes;
        
    }

    protected function recursiveAddChild(&$routes, $parent) {
        
        foreach($routes as $key => $value) {
            
            if($key == $parent) {
                if(isset($value['child_routes'])) {
                    $value->child_routes->merge($this->getRoute());
                    
                } else {
                    $value->child_routes = array();
                    $value->child_routes->merge($this->getRoute());
                }
            } else if (isset($value['child_routes'])) {
               
                $this->recursiveAddChild($value['child_routes'], $parent);
            } 

        }

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
        
        $terminate = $this->routeObject->getTerminate();
        if(null != $terminate) {
            $route->$name->may_terminate = $terminate;
        }

        return $route;
    }

    protected function getRouteOptions() {
        
        $options = $this->configHelper->getConfigObject();

        $options->route = $this->routeObject->getRoute();
        
        $constraints = $this->routeObject->getRouteConstraints();
        $defaults    = $this->routeObject->getRouteDefaults(); 
        
        if(null != $constraints) {
            $options->constraints = array();
            foreach($constraints as $k => $v) {
                $options->constraints->$k = $v;
            }
        }

        if(null != $defaults) {
            $options->defaults = array();
            foreach($defaults as $k => $v) {
                $options->defaults->$k = $v;
            }
        }
        return $options;
    }

}
