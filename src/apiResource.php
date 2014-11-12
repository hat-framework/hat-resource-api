<?php

class apiResource extends \classes\Interfaces\resource{
    
    public function LoadApiClass($apiname, $args = array()){
        $class = "{$apiname}API";
        $dir   = dirname(__FILE__) . DS."$apiname".DS."$class.php";
        if(!file_exists($dir)){return null;}
        require_once $dir;
        
        if(!class_exists($class, false)){return null;}
        return new $class($args);
       
    }
    
}
