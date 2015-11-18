<?php

class luckyorangeAPI extends \classes\Interfaces\resource{
    
    public function startAnalytics($print = true){
        static $loaded = false;
        if($loaded === true){return;}
        else{$loaded = true;}
        if(!defined('API_LUCK_ORANGE_KEY') || API_LUCK_ORANGE_KEY == ""){return;}
        if(usuario_loginModel::IsWebmaster()){return;}
        $str   = '<script type="text/javascript">
        window.__wtw_lucky_site_id = '.API_LUCK_ORANGE_KEY.';
	(function() {
            var wa = document.createElement("script"); wa.type = "text/javascript"; wa.async = true;
            wa.src = ("https:" == document.location.protocol ? "https://ssl" : "http://cdn") + ".luckyorange.com/w.js";
            var s = document.getElementsByTagName("script")[0]; s.parentNode.insertBefore(wa, s);
	  })();
	</script>';
        return $this->printstr($print, $str);
    }
    
    private function printstr($print, $str){
        if(false == $print){return $str;}
        echo $str;
    }
    
}
