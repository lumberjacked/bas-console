<?php
namespace BasConsole\Services;

use BasConsole\Helpers;

class RouteService {

    protected $configHelper;

    protected $stringHelper;

    public function __construct(Helpers\ConfigHelper $configHelper, Helpers\StringHelper $stringHelper) {
        $this->configHelper = $configHelper;
        $this->stringHelper = $stringHelper;
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
