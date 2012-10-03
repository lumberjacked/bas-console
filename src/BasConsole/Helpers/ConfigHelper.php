<?php 
namespace BasConsole\Helpers;

class ConfigHelper 
{
    private $workingDir;

    public function __construct() {
        $this->workingDir = getcwd();
    }

    public function getConfig($moduleName = null) {
        //var_dump($this->recursiveGlob($this->workingDir, 'application.config.php'));die();
        var_dump($this->recursiveGlob($this->workingDir, 'module.config.php'));die();
    }

    public function recursiveGlob($path, $pattern = '*', $flag = 0) {
        
        $paths = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
        $files = glob($path.$pattern, $flag);

        foreach($paths as $path) {
            $files = array_merge($files, $this->recursiveGlob($path, $pattern, $flag));
        }

        return $files;
    }
        
}
