<?php 
namespace BasConsole\Objects;

use BasConsole\Helpers\ConfigHelper;

class RouteObject {
    
    protected $configHelper;

    protected $config;
    
    protected $routeName; 

    protected $route;

    protected $moduleName;

    protected $routeType;

    public function __construct(ConfigHelper $configHelper) {
        $this->configHelper = $configHelper;
    }
    
    public function setArguments($arguments) {
        $this->routeName = $arguments['{RouteName}'];
        $this->route     = $arguments['{Route}'];
        return $this;
    }

    public function setOptions($options) {
        $this->routeType  = $options['type'];
        $this->moduleName = $options['module'];
        return $this;
    }

    public function getConfig() {
        if(isset($this->config)) {
            return $this->config;
        } else {
            $this->config = $this->configHelper->getConfig($this->moduleName);
            return $this->config;
        }

        
    }


}
