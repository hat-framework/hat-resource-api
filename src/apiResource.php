<?php

class apiResource extends \classes\Interfaces\resource{
    
    public function LoadApiClass($apiname, $args = array()){
        $e     = explode("/", $apiname);
        $clnm  = array_pop($e);
        $class = "{$clnm}API";
        $appnm = implode("/", $e);
        if($appnm == ""){$appnm = $clnm;}
        $dir   = dirname(__FILE__) . DS."$appnm".DS."$class.php";
        if(!file_exists($dir)){return null;}
        require_once $dir;
        if(false === $this->filtherClass($class, $appnm)){return null;}
        return new $class($args);
    }
    
            private function filtherClass(&$class, $appnm){
                if(class_exists($class, false)){return true;}
                $class1 = "resource\\api\\$appnm\\$class";
                if(class_exists($class1, false)){
                    $class = $class1;
                    return true;
                }
                $class2 = "resource\\api\\$class";
                if(class_exists($class2, false)){
                    $class = $class2;
                    return true;
                }
                return false;
            }
    
}
