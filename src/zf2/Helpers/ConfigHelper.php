<?php 
namespace BAS\zf2\Helpers;

class ConfigHelper 
{
    protected $wd;

    protected $application_config;
    
    public function __construct() {
        
        $this->setWorkingDir(getcwd());
        $this->setApplicationConfig();
        
    }

    protected function setWorkingDir($wd = null) {
        if(null != $wd) {
            $this->wd = $wd;
        }
        return $this->wd;
    }

    protected function setApplicationConfig() {
        
        if(is_file($this->wd . '/config/application.config.php')) {
            $this->application_config = include $this->wd . '/config/application.config.php';
        }
        return $this->application_config;        
    }

    public function getApplicationConfig() {
        
        if(null != $this->application_config) {
            return $this->application_config;
        } else {
            $this->setApplicationConfig();
        }
    }

        
}
