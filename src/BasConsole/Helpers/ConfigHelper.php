<?php 
namespace BasConsole\Helpers;

class ConfigHelper 
{
    private $workingDir;

    private $configPath;

    private $directoryPath;

    public function __construct() {
        $this->workingDir = getcwd();
    }

    public function getConfig($path = null, $moduleName = null) {
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

    protected function checkIfDirectoryIsActive($path, $moduleName) {
        if(null == $path) {
            if(null !== $moduleName) {
                if(is_file($this->workingDir . "/module/{$moduleName}/config/module.config.php")) {
                    $configPath    = $this->setConfigPath($this->workingDir . "/module/{$moduleName}/config/module.config.php");
                    $directoryPath = $this->setDirectoryPath($this->workingDir . "/module/{$moduleName}/config");    
                    
                    
                    return include $configPath; 
                } else {
                    throw new \Exception("Could not find 'module.config.php' for Module {$moduleName}. Supply --path='/path/to/project/root'.");
                }
            }        
        } else if(null !== $path) {
            if(null !== $moduleName) {
                if(is_file($path . "/module/{$moduleName}/config/module.config.php")) {
                    $configPath = $path . "/module/{$moduleName}/config/module.config.php"; 
                    $this->setConfigPath($configPath);
                    return include $configPath; 
                } else {
                    throw new \Exception("Could not find 'module.config.php' for Module {$moduleName}. Supply --path='path/to/project/root'.");
                }          
            }
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

    public function writeNewRouteConfig($config = null) {
        
        
        $testPath = "/home/lumberjacked/workspace/zf2.dev/module/Application/config/test.php";
           
        

       

       file_put_contents($testPath, '<?php return ' . var_export($config, true) . ';');

         
     
    }

    public function writeChangesConfig($config) {
        $testPath = "/home/lumberjacked/workspace/zf2.dev/module/Application/config/test.php";
        file_put_contents($testPath, $config);

        return true;
    }

    public function searchNewRouteConfig() {
        $searchthis = "'/home/lumberjacked/workspace/zf2.dev/module/Application";
        $count      = strlen($searchthis);
        
        $newFile = array();

        
        $handle = @fopen("/home/lumberjacked/workspace/zf2.dev/module/Application/config/test.php", "r");
            if ($handle) {
                while (!feof($handle)) {
                    $buffer = fgets($handle);
                    if(strpos($buffer, $searchthis) !== false) {
                        $pos = strpos($buffer, $searchthis);
                       
                        $buffer = substr_replace($buffer, '__DIR__ . "', $pos, $count);
                        $newFile[] = $buffer;
                                          
                    } else {
                        $newFile[] = $buffer;
                    }
                    
                }
                fclose($handle);
            }
        //var_dump($newFile);die();
        var_dump($this->writeChangesConfig($newFile));die();
    }


        
}
