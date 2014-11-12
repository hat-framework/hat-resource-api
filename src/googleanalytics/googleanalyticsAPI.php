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
        $this->html->LoadJsFunction("ga('create', '$key', '$u');ga('send', 'pageview');");
    }
    
}
