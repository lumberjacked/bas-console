<?php
namespace BasConsole\Services;


class RouteService {

    protected $routeName;

    protected $routeModule;

    protected $routeType;
    
    public function __construct() {

    }

    public function executeCommand() {
        $this->checkModule($routeModule);
    }

    public function setRouteName($routeName = null) {
        $this->routeName = $routeName;
    }

    public function setRouteType($routeType = null) {
        $this->routeType = $routeType;
    }

    public function setModuleName($routeModule = null) {
        $this->routeModule = $routeModule;
    }
    
}
