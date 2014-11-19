<?php

class googleanalyticsAPI extends \classes\Interfaces\resource{
    
    public function startAnalytics($key = ''){
        static $loaded = false;
        if($loaded === true){return;}
        $loaded = true;
        if($key === ""){
            if(!defined('API_GA_KEY')){return;}
            $key = API_GA_KEY;
        }
        $url = \classes\Classes\Registered::getResourceLocationUrl('api')."/src/googleanalytics/ga.js";
        $this->LoadResource("html", 'html')->LoadJs($url);
        
        $u = $_SERVER['SERVER_NAME'] ;
        $cod   = \usuario_loginModel::CodUsuario();
        $extra = ($cod !== 0)?"ga('set', '&uid', '$cod');":"";
        $this->html->LoadJsFunction("ga('create', '$key', '$u');ga('send', 'pageview'); $extra");
    }
    
}
