<?php 
namespace BasConsole\Helpers;

class ConfigHelper 
{
    private $workingDir;

    public function __construct() {
        $this->workingDir = getcwd();
    }

    public function getConfig() {
        var_dump($this->workingDir);die('working');
    }
        
}
