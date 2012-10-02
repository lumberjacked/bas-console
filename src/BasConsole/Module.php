<?php
namespace BasConsole;

class Module {

    public function getServiceConfig() {
        
        return new Services\ServiceConfiguration();
    }

    public function getConfig() {
        return include __DIR__ . '/../../config/module.config.php';
    } 

}
