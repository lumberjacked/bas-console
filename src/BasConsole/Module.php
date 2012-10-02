<?php

namespace BAS\CommandConsole;

use Zend\ServiceManager\ConfigInterface;

class Module implements ConfigInterface {

    public function getServiceConfig() {
        return array();
    }

}
