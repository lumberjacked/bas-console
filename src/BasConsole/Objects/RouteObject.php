<?php 
namespace BasConsole\Objects;

use BasConsole\Services\RouteService,
    Zend\Config\Config,
    Zend\Config\Writer\PhpArray;

class RouteObject {

    protected $moduleName;

    protected $projectPath;
    
    protected $routeName; 

    protected $route;

    protected $routeType = "Segment";

    protected $defaults;

    protected $constraints;

    public function __construct() {
    
    }

    public function executeCommand() {
        
    } 
    
    public function setArguments($arguments) {
        $this->routeName = $arguments['{RouteName}'];
        $this->route     = $arguments['{Route}'];
        return $this;
    }

    public function setOptions($options) {
        $this->routeType   = $options['type'];
        $this->moduleName  = $options['module'];
        $this->projectPath = $options['path'];
        $this->setRouteDefaults($options['defaults']);
        $this->setRouteConstraints($options['constraints']);
        return $this;
    }

    

    protected function setRouteDefaults($defaults = null) {
        if(null !== $defaults) {
            //$this->defaults = $this->stringHelper->explodeString($defaults);
        } else {
            $this->defaults = $defaults;
        }
    }

    protected function setRouteConstraints($constraints = null) {
        if(null !== $constraints) {
            //$this->constraints = $this->stringHelper->explodeString($constraints);
        } else {
            $this->constraints = $constraints;
        }
    }
 
    protected function getRoute() {
        
        //$route = $this->configHelper->getConfig();
        $name  = $this->routeName;
        $route->$name = array();
        $route->$name->type = $this->routeType;
        $route->$name->options = $this->getRouteOptions();

        return $route;
    }

    protected function getRouteOptions() {
        
        //$options = $this->configHelper->getConfig();

        $options->route = $this->route;
       
        if(null != $this->defaults) {
            $options->defaults = array();
            foreach($this->defaults as $k => $v) {
                $options->defaults->$k = $v;
            }
        }
        return $options;
    }

    protected function getRouteConstraints() {

    }

}
