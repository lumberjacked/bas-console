<?php 
namespace BAS\zf2\Commands;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface;

class ModuleCommand extends Command 
{
    
    protected $_namespace;

    protected $_controller = 'Default';

    protected $_md;   
    
    protected function configure() {

        $this->_md = getcwd() . '/module';
        
        $this->setName('generate:module')->setDescription('Create a Brand Spanking New zf2 Module in an Exsisting Project!')
             ->addArgument('{ModuleName}', InputArgument::REQUIRED, 'Please choose a Name for this Module.')
             ->addArgument('{ControllerName}', InputArgument::OPTIONAL, 'Enter a Default Controller Name!');

    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $this->setNamespace($input->getArgument('{ModuleName}'));
        $controller = $input->getArgument('{ControllerName}');
        
        if($controller) {
            $this->setController($controller);
        }
        
        $this->createModule($output);

        
    }

    protected function createModule(OutputInterface $output) {
                 
        if(is_dir($this->_md) && !is_dir($this->_md . "/{$this->getNamespace()}")) {
          
            $this->createDirStructure($this->_md, $this->getModuleDirectoryArray()); 
            $output->writeln("<info>{$this->getNamespace()} Directory Structure Created</info>");

            $this->createFiles();
            $output->writeln("<info>Created {$this->getNamespace()} Module Files</info>");



        } else {
            throw new \Exception("Another Module found with this Name!");
        }       


    }

    protected function getModuleDirectoryArray() {
        
        return array(
            $this->getNamespace() => array(
                'config',
                'src' => array(
                    $this->getNamespace() => array(
                        'Controller',
                        'Form',
                        'Model',
                    ),
                ),
                'view' => array(
                    strtolower($this->getNamespace()) => array(
                        strtolower($this->getController())
                    )
                )
            )                
        );
    }

    protected function getFileStructure() {
        
        $namespace = $this->getNamespace();
        $structure = array(
                        'Module.php'            => $this->_md . "/{$namespace}",
                        'autoload_classmap.php' => $this->_md . "/{$namespace}", 
                        'module.config.php'     => $this->_md . "/{$namespace}/config"
                      );
     
        return $structure; 
    }

    protected function getModuleFile() {
        
        return <<<MODULE
// module/{$this->getNamespace()}/Module.php
<?php
namespace {$this->getNamespace()};

class Module {
                
    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . 'autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }
}
MODULE;

    }

    protected function getAutoloadMapFile() {
        
        return <<<MAP
// module/{$this->getNamespace()}/autoload_classmap.php
<?php
return array();
MAP;
    }

    protected function getModuleConfigFile() {
        
        $lowerNamedspace = strtolower($this->getNamespace());
        return <<<CONFIG
// module/{$this->getNamespace()}/config/module.config.php
<?php
return array(
    'controllers' => array(
        'invokables' => array(
            '{$this->getNamespace()}\Controller\Default' => '{$this->getNamespace()}\Controller\DefaultController',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            '{$lowerNamedspace}' => __DIR__ . '/../view',
        ),
    ),
);
CONFIG;
    }

    protected function getNamespace() {
        return $this->_namespace;
    }

    protected function setNamespace($namespace = null) {
        if(null !== $namespace) {
            $this->_namespace = ucfirst($namespace);
        }
        return $this->_namespace;
    }

    protected function getController() {
        return $this->_controller;
    }

    protected function setController($controller = null) {
        if(null !== $controller) {
            $this->_controller = ucfirst($controller);
        }
        return $this->_controller;
    }

    protected function createDirStructure($base_path = null, $structure = null, $file_mode = 0755) {
       
        if(null !== $base_path || null !== $structure) {
            foreach($structure as $key => $value) {
             
                $dir = is_string($key) ? $key : $value;
                $path = $base_path . '/' . $dir;

                    if(!file_exists($path)) {              
                        mkdir($path, $file_mode);
                    } else {
                        chmod($path, $file_mode);    
                    }

                if(is_array($value)) {
                    $this->createDirStructure($path, $value);
                }

            }   
        }    
    }

    protected function createFiles() {
        
        $structure = $this->getFileStructure();

        foreach($structure as $file => $path) {
            
            $handle = fopen($path . "/{$file}", 'w') or die('Cannot open file: ' . $file);

            switch($file) {
                case 'Module.php':
                    $data = $this->getModuleFile();
                    break;
                case 'autoload_classmap.php':
                    $data = $this->getAutoloadMapFile();
                    break;
                case 'module.config.php':
                    $data = $this->getModuleConfigFile();
                    break;
            }

            fwrite($handle, $data);
            fclose($handle);
        }
    }

}
