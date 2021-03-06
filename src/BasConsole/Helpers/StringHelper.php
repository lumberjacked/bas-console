<?php 
namespace BasConsole\Helpers;

class StringHelper 
{

    public function __construct() {
        
    }

    public function explodeString($string) {
        
        $array = explode(',', $string);
        $result = array();

        foreach($array as $value) {
            if(!empty($value)) {
                $pair = explode(":", $value);
           
                if(count($pair) % 2) {
                    throw new \Exception('Your Key:Value pairs are incorrect');
                }
                $result[trim($pair[0])] = trim($pair[1]);
            }
        }

        if(!empty($result)) {
            return $result;
        } else {
            return NULL;
        }
    }

    public function recursiveArrayReplace(&$array, $search, $replace) {
        
        foreach($array as $k => $v) {
            if(is_array($v)) {
               $array[$k] = $this->recursiveArrayReplace($v, $search, $replace);
            } else {
                
                $array[$k] = str_replace($search, $replace, $v); 
            }
        }

        return $array;

    }

    
       
}
