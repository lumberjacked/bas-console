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
            $pair = explode(":", $value);
            if(count($pair) % 2) {
                throw new \Exception('Your Key:Value pairs are incorrect');
            }
            $result[$pair[0]] = $pair[1];
        }

        return $result;
    }
       
}
