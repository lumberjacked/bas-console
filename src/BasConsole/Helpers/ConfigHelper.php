<?php 
namespace BasConsole\Helpers;

use BasConsole\Factories\ConfigFactory,
    Zend\Config\Config,
    Zend\Config\Writer\PhpArray;

class ConfigHelper 
{
    private $workingDir;

    private $configPath;

    private $directoryPath;

    private $configFactory;

    public function __construct($factory) {
        $this->workingDir    = getcwd();
        $this->configFactory = $factory;
    }

    public function getModuleConfig($path = null, $moduleName = null) {
        return $this->checkIfDirectoryIsActive($path, $moduleName);
    }

    public function getConfigPath() {
        // Returning this for now but needs to check if set then return if not then run a setter on the path
        return $this->configPath;
    }

    protected function setConfigPath($path) {
        $this->configPath = $path;
        return $this->configPath;    
    }

    protected function setDirectoryPath($path) {
        $this->directoryPath = $path;
    }

    public function getDirectoryPath() {
        return $this->directoryPath;    
    }

    public function getConfigObject(array $array = array(), $true = true) {
        return $this->configFactory->getConfigObject($array, $true);
    }

    protected function checkIfDirectoryIsActive($path, $moduleName) {
        
        if(null == $moduleName) {
            $moduleName = 'Application';
        }
        
        if(null == $path) {
            return $this->checkIfConfigFileIsActive($moduleName, $this->workingDir);    
        } else if (null !== $path) {
            return $this->checkIfConfigFileIsActive($moduleName, $path);
        }   
    }

    protected function checkIfConfigFileIsActive($moduleName, $path) {
        if(is_file($path . "/module/{$moduleName}/config/module.config.php")) {
            $configPath    = $this->setConfigPath($this->workingDir . "/module/{$moduleName}/config/module.config.php");
            $directoryPath = $this->setDirectoryPath($this->workingDir . "/module/{$moduleName}/config");    
                    
            return $this->configFactory->getConfigObject(include $configPath, true); 
        } else {
            throw new \Exception("Could not find 'module.config.php' for Module {$moduleName}. Supply --path='/path/to/project/root'.");
        }    
    }

    public function recursiveGlob($path, $pattern = '*', $flag = 0) {
        
        $paths = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
        $files = glob($path.$pattern, $flag);

        foreach($paths as $path) {
            $files = array_merge($files, $this->recursiveGlob($path, $pattern, $flag));
        }

        return $files;
    }

    public function newConfigToFile($config) {
    
        $writer = $this->configFactory->getPhpWriter();       
        $writer->toFile($this->configPath, $config);
       
        $this->replaceMagicConstants();
    }

    public function replaceMagicConstants() {
        $searchthis = "'" . $this->getDirectoryPath();
       
        $count      = strlen($searchthis);
        
        $newFile = array();
      
        $handle = @fopen($this->configPath, "r");
            if ($handle) {
                while (!feof($handle)) {
                    $buffer = fgets($handle);
                    if(strpos($buffer, $searchthis) !== false) {
                        $pos = strpos($buffer, $searchthis);
                       
                        $buffer = substr_replace($buffer, "__DIR__ . '", $pos, $count);
                        $newFile[] = $buffer;
                                          
                    } else {
                        $newFile[] = $buffer;
                    }
                    
                }
                fclose($handle);
            }
        
        $this->toFile($this->configPath, $newFile);
    }

    private function toFile($filepath, array $data = array(), $exclusiveLock = true) {
         if (empty($filepath)) {
            throw new \Exception('No file path specified');
        }
    
        if(empty($data)) {
            throw new \Exception('No file contents specified');
        }

        $flags = 0;
        if ($exclusiveLock) {
            $flags |= LOCK_EX;
        }

        file_put_contents($filepath,$data, $flags);
     

    }


        
}
