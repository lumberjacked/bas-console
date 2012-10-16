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

    protected $parent;

    protected $routeType = "Literal";

    protected $terminate;

    protected $defaults;

    protected $constraints; 
    
    public function configureObject(array $configuration) {
        
        $this->setArguments($configuration['arguments']);
        $this->setOptions($configuration['options']);
        
        if(null != $this->parent) {
            $this->setRouteType('Segment');
        }
    }

    protected function setArguments($arguments) {
        $this->routeName = $arguments['{RouteName}'];
        $this->route     = $arguments['{Route}'];
    }

    protected function setOptions($options) {
        $this->routeType   = $options['type'];
        $this->parent      = $options['parent'];
        $this->moduleName  = $options['module'];
        $this->projectPath = $options['path'];
        $this->defaults    = $options['defaults'];
        $this->constraints = $options['constraints'];
        $this->setTerminate($options['terminate']);
    }

    protected function setRouteType($type) {
        $this->routeType = $type;
    }

    protected function setTerminate($terminate) {
         
        if(null != $terminate){
            $terminate = strtolower($terminate);
            if($terminate == 'true') {
                $this->terminate = true;
            } else if ($terminate == 'false') {
                $this->terminate = false;
            } else {
                throw new \Exception('`may_terminate` option must be of type Boolean');
            }
        } else {
            $this->terminate = $terminate; 
        }
    }

    public function getRouteName() {
        return $this->routeName;
    }

    public function getRoute() {
        return $this->route;
    }

    public function getParent() {
        return $this->parent;
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

    public function getTerminate() {
        return $this->terminate;
    }

    public function getProjectPath() {
        return $this->projectPath;
    }

    public function getModuleName() {
        return $this->moduleName;
    }

}
