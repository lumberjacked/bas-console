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

        $this->finishPropertyConfig();
    }

    protected function finishPropertyConfig() {
        
        if(null != $this->_properties->terminate) {
            $this->_properties->terminate = $this->configureTerminate($this->_properties->get('terminate'));
        }

        if($this->_properties->command != "route:update") {
            $this->_properties->type = $this->configureType($this->_properties->get('type'), $this->_properties->get('parent'));
        }
    
    } 

    public function get($property) {
        return $this->_properties->get($property);
    }

    protected function configureTerminate($terminate = null) {
        
        if(null != $terminate){
            $terminate = strtolower($terminate);
            if($terminate == 'true') {
                $terminate = true;
            } else if ($terminate == 'false') {
                $terminate = false;
            } else {
                throw new \Exception('`may_terminate` option must be of type Boolean');
            }
        } else {
            $terminate = $terminate; 
        }
        return $terminate;
    }

    protected function configureType($type, $parent) {
        
        $type = strtolower($type);  
        if(null != $parent && "literal" == $type) {
            $type = 'Segment';

        } else {    
            $type = ucfirst($type);

        }
        return $type;
    }

}
