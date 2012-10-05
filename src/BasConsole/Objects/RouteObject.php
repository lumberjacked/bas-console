<?php 
namespace BasConsole\Objects;

use BasConsole\Helpers;

class RouteObject {
    
    protected $configHelper;

    protected $stringHelper;

    protected $config;

    protected $moduleName;

    protected $projectPath;
    
    protected $routeName; 

    protected $route;

    protected $routeType = "Segment";

    protected $defaults;

    public function __construct(Helpers\ConfigHelper $configHelper, Helpers\StringHelper $stringHelper) {
        $this->configHelper = $configHelper;
        $this->stringHelper = $stringHelper;
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
        $this->defaults    = $this->stringHelper->explodeString($options['defaults']);
        return $this;
    }

    protected function getConfig() {
        if(isset($this->config)) {
            return $this->config;
        } else {
            $this->config = $this->configHelper->getConfig($this->projectPath, $this->moduleName);
            return $this->config;
        }   
    }

    public function buildRoute() {
        $config = $this->getConfig();

        if($config['router']['routes']) {
            $router = $config['router']['routes'];
            if(in_array($this->routeName, $router)) {
                die('route exsists');
            } else {
                var_dump($this->getRouteArray());die();
            }
        } else {
            die('false');
        }
    }

    protected function getRouteArray() {
        $route = array(
            $this->routeName => array(
                    'type'    => $this->routeType,
                    'options' => array(
                        'route'    => $this->routeName,
                        'defaults' => $this->defaults, 
                    )
                )
      
        );

        return $route;
    }

}
