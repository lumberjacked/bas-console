<?php
namespace BasConsole;

class Module {

    public function getServiceConfig() {
        
        return new Services\ServiceConfiguration();
    } 

}
