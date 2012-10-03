<?php
namespace BasConsole\Services;

use BasConsole\Objects\RouteObject;

class RouteService {

    protected $routeObject;

    public function __construct(RouteObject $routeObject) {
        $this->routeObject = $routeObject;
    }
    
    public function executeCommand() {
        $this->buildRoute();       
    }

    public function getRouteObject() {
        return $this->routeObject;
    }

    private function buildRoute() {
        $config = $this->routeObject->getConfig();

        
    }  
}
