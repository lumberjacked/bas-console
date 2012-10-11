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
    
    public function setArguments($arguments) {
        $this->routeName = $arguments['{RouteName}'];
        $this->route     = $arguments['{Route}'];
        return $this;
    }

    public function setOptions($options) {
        $this->routeType   = $options['type'];
        $this->moduleName  = $options['module'];
        $this->projectPath = $options['path'];
        $this->defaults    = $options['defaults'];
        $this->constraints = $options['constraints'];
        return $this;
    }

    public function getRouteName() {
        return $this->routeName;
    }

    public function getRoute() {
        return $this->route;
    }

    public function getRouteType() {
        return $this->routeType; 
    }

    public function getRouteDefaults() {
        return $this->defaults;
    }

    public function getRouteConstraints() {
        return $this->constraints;
    }

    public function getProjectPath() {
        return $this->projectPath;
    }

    public function getModuleName() {
        return $this->moduleName;
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


}
