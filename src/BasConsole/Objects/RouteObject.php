<?php 
namespace BasConsole\Objects;

use BasConsole\Services\RouteService,
    Zend\Config\Config,
    Zend\Config\Writer\PhpArray;

class RouteObject {

    protected $_properties;

    protected $moduleName;

    protected $projectPath;
    
    protected $routeName; 

    protected $route;

    protected $parent;

    protected $routeType = "Literal";

    protected $terminate;

    protected $defaults;

    protected $constraints; 
    
    public function __construct(Config $propertiesConfig) {
        $this->_properties = $propertiesConfig;    
    }
    
    public function configureObject(array $configuration) {
        $this->setObjectProperties($configuration);
    }
    
    protected function setObjectProperties(array $properties) {
        
        foreach($properties as $property => $value) {
            $this->_properties->$property = $value;    
        }
        var_dump($this->get('{RouteName}'));die();
    } 

    public function get($property) {
        return $this->_properties->get($property);
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

    protected function setRouteType($type) {
        
        if(null != $this->parent && null == $type) {
            $this->routeType = 'Segment';
        } else if (null == $type) {
            $this->routeType = 'Literal';
        } else {
            $this->routeType = $type;
        }

    }

    protected function setArguments($arguments) {
        $this->routeName = $arguments['{RouteName}'];
        $this->route     = $arguments['{Route}'];
    }

    protected function setOptions($options) {
        
        $this->parent      = $options['parent'];
        $this->setRouteType($options['type']); 
        $this->moduleName  = $options['module'];
        $this->projectPath = $options['path'];
        $this->defaults    = $options['defaults'];
        $this->constraints = $options['constraints'];
        $this->setTerminate($options['terminate']);
    }

}
