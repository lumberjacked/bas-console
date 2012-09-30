<?php 
namespace BAS\zf2;


class ConsoleCommands 
{
	protected $_commands;
	
    public function __construct() {
	    $this->_commands = $this->createCommands();		
	}

	private function createCommands() {
        if(is_dir(__DIR__ . '/Commands')) {
		    
            if($handle = opendir(__DIR__ . '/Commands')) {
			    $commands = array();
                
                while (false !== ($string = readdir($handle))) {
				    $class = $this->_parseClassName($string);                    
				    
                    if(null !== $class) {
                        $commands[] = new $class();
                    }
			    }
		    }	

		} else {
            throw new \Exception('Something is wrong with your installtion, Cannot find Commands directory');	
		}
	    return $commands;
	}

    public function getCommands() {
        if(null !== $this->_commands) {
		    return $this->_commands;
        } else {
            $this->_commands = $this->createCommands();
            return $this->_commands;
        }
    }

    protected function _parseClassName($string = null) {
        
        if(null !== $string) {
            $length = strlen($string);
            $start = $length - 4;
                    
                if(substr($string, $start, 4) == '.php') {
                    $class = substr($string, 0, -4);
                    $class = "BAS\zf2\Commands\\{$class}";

                } else {
                    $class = null;
                }            
        } else {
            $class = null;
        }
        return $class;     
    }

}

