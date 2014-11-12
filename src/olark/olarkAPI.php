<?php

class olarkAPI extends \classes\Interfaces\resource{
    
    public function startOlark($key = ''){
        static $loaded = false;
        if($loaded === true){return;}
        $loaded = true;
        if($key === ""){
            if(!defined('API_OLARK_KEY')){return;}
            $key = API_OLARK_KEY;
        }
        $url = \classes\Classes\Registered::getResourceLocationUrl('api')."/src/olark/olark.js";
        $this->LoadResource("html", 'html')->LoadJs($url);
        $this->html->LoadJsFunction("olark.identify('$key');");
    }
    
}
