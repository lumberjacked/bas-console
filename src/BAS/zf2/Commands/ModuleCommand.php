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

    protected $_moduleFile;   

    protected function configure() {
        $this->setName('generate:module')->setDescription('Create a Brand Spanking New zf2 Module in an Exsisting Project!')
             ->addArgument('{ModuleName}', InputArgument::REQUIRED, 'Please choose a Name for this Module.');

    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $output->writeln("<info>Creating a Module</info>");
        $output->writeln("<comment>Things to Remember</comment>");
        $output->writeln("<error>Required Argument -- Namespace</error>");
        $output->writeln("<error>Required Argument -- Module Name</error>");
        $output->writeln("<error>Maybe doesn't happen here but will need a route to each view file (This is a new command)</error>");

        $this->setNamespace($input->getArgument('{ModuleName}'));

        $this->createDirectoryStructure();

        
    }

    protected function createDirectoryStructure() {
        
        $structure = $this->getModuleDirectoryArray();
        $workingDirectory = getcwd();
        var_dump(__DIR__);
        var_dump($workingDirectory);
        var_dump($structure);die('structure');        

    }

    protected function getModuleDirectoryArray() {
        
        return array(
            'ModuleName' => array(
                'config',
                'src' => array(
                    'ModuleName' => array(
                        'Controller',
                        'Form',
                        'Model',
                    ),
                ),
                'view' => array(
                    'ModuleNameLower' => array(
                        'ControllerNameLower'
                    )
                )
            )                
        );

    }

    protected function getModuleFile() {
        
        if(null !== $this->_moduleFile) {
            return $this->_moduleFile;
        } else {
            $this->setModuleFile();
            return $this->_moduleFile;
        }
    }

    protected function setModuleFile() {
        $this->_moduleFile =
<<<MODULE
// module/{$this->getNamespace()}/Module.php
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
  
        return $this->_moduleFile;
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

}
