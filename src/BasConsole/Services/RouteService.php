<?php
namespace BasConsole\Services;

use BasConsole\Objects\RouteObject;

class RouteService {

    protected $routeObject;

    public function __construct(RouteObject $routeObject) {
        $this->routeObject = $routeObject;
    }
    
    public function executeCommand() {
        return $this->cleanUpMessage($this->routeObject->buildRoute());       
    }

    public function getRouteObject() {
        return $this->routeObject;
    }

    public function cleanUpMessage($message) {
       
        $message = substr($message, 12);
        $message = substr($message, 0, -2);
        return $message;
    }
 
}
