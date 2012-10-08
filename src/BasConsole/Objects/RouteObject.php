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
        $this->setRouteDefaults($options['defaults']);
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

    protected function setRouteDefaults($defaults = null) {
        if(null !== $defaults) {
            $this->defaults = $this->stringHelper->explodeString($defaults);
        } else {
            $this->defaults = $defaults;
        }
    }

    public function buildRoute() {
        $config = $this->getConfig();
         
        if($config['router']['routes']) {
            $router = $config['router']['routes'];
            if(in_array($this->routeName, $router)) {
                throw new \Exception('I found a route in this Module with the same name.  Run route:update if you need to modify this route.');
            } else {
                $routes = array_merge($router, $this->getRouteArray());
                $mergeRouter =array(
                    'router' => array(
                        'routes' => $routes,
                    )
                );
                
                $config = array_merge($config, $mergeRouter);
                $config = $this->stringHelper->recursiveArrayReplace($config, "'{$this->configHelper->getDirectoryPath()}", '__DIR__ . "');
                
                //$config = $this->stringHelper->recursiveArrayReplace($config, '"', " ");
                var_dump($this->configHelper->writeNewRouteConfig($config));die('build route'); 
                //var_dump($this->configHelper->searchNewRouteConfig($config));die('build route'); 
            }
        } else {
            die('false no option in config for router routes');
        }
    }

    protected function getRouteArray() {
        $route = array(
            $this->routeName => array(
                    'type'    => $this->routeType,
                    'options' => $this->getRouteOptions(),
            ),
        );

        return $route;
    }

    protected function getRouteOptions() {
        $options = array(
               'route' => $this->route
        );

        if(null != $this->defaults) {
            $options['defaults'] = $this->defaults;
        }

        return $options;
    }

}
