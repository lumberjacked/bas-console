<?php 
namespace BasConsole\Objects;

use BasConsole\Services\RouteService,
    Zend\Config\Config,
    Zend\Config\Writer\PhpArray;

class RouteObject {

    protected $_properties; 
    
    public function __construct(Config $propertiesConfig) {
        $this->_properties = $propertiesConfig;    
    }
    
    public function get($property) {
        return $this->_properties->property->get($property);
    }

    public function getArray($property) {
        return $this->_properties->property->get($property)->toArray();
    }
    
    public function getAll() {
        $array = array();
        
        foreach($this->_properties->property as $key => $value) {
            
            if(null != $value) {
                $array[$key] = $value;
            }
        }
        return $array;
    }

    public function getUpdateOptions() {
        $array  = array();
        $remove = array('module', 'command', 'RouteName');
        foreach($this->_properties->property as $key => $value) {
            if(!in_array($key, $remove) && null != $value) {
                $array[$key] = $value;
            }
        }
        return $array;
    }
 
    public function configureObject(array $configuration) {
        $this->setObjectProperties($configuration);
    }
    
    protected function setObjectProperties(array $properties) {
        
        $extras = array('help', 'quiet', 'verbose', ' version', 'ansi', 'no-ansi', 'no-interaction');   
        $this->_properties->property = array();
        $this->_properties->extras  = array();
        foreach($properties as $property => $value) {
            if(!in_array($property, $extras)) {
                $this->_properties->property->$property = $value;
            } else {
                $this->_properties->extras->$property = $value;
            }    
        }

        if(null != $this->_properties->property->terminate) {
            $this->_properties->property->terminate = $this->configureTerminate($this->_properties->property->get('terminate'));
        }

        if($this->_properties->property->command != "route:update") {
            $this->_properties->property->type = $this->configureType($this->_properties->property->get('type'), $this->_properties->property->get('parent'));
        }

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
