<?php 
namespace BasConsole\Factories;

use Zend\ServiceManager\ServiceManager;

class ConsoleCommandsFactory 
{
	protected $_commands;

    protected $_sm;
	
    public function __construct(ServiceManager $sm, array $config = array()) {
        $this->_sm = $sm;
        $this->setCommands($config);
            
    }
    
    private function setCommands(array $config) {
        if(isset($config['console']['commands']) && !empty($config['console']['commands'])) {
            foreach($config['console']['commands'] as $command) {
                $this->_commands[] = $this->_sm->get("{$command}");
            }
        }
    }    

    public function getCommands() {
        return $this->_commands;
    }

}

