<?php

class facebookAPI extends \classes\Interfaces\resource{
    
    public function comments(){
        return $this->load(__FUNCTION__);
    }
    
    public function like(){
        return $this->load(__FUNCTION__);
    }
    
    public function likebox(){
        return $this->load(__FUNCTION__);
    }
    
    private function load($fn){
        $class = "facebook".  ucfirst($fn);
        $path = dirname(__FILE__)."/classes/$class.php";
        if(!file_exists($path)){throw new InvalidArgumentException("o arquivo da classe $class não existe!");}
        require_once $path;
        
        if(!class_exists($class, false)){throw new InvalidArgumentException("A classe $class não existe!");}
        $this->loadScript();
        return new $class();
    }
    
    private function getAppId(){
        return defined("API_FACEBOOK_APPID")?API_FACEBOOK_APPID:"";
    }
    
    private function loadScript(){
        static $loaded = false; 
        if($loaded === true){return;}
        $loaded = true;
        $appid = $this->getAppId();
        echo '<div id="fb-root"></div>';
        echo '<script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId='.$appid.'&version=v2.0";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, "script", "facebook-jssdk"));</script>';
    }
    
}
