<?php

class adwordsAPI extends \classes\Interfaces\resource{
    
    public function remarketing($print = true){
        static $loaded = false;
        if($loaded === true){return;}
        else{$loaded = true;}
        if(!defined('API_ADWORDS_KEY') || API_ADWORDS_KEY == ""){return;}
        if(usuario_loginModel::IsWebmaster()){return;}
        
        $key   = API_ADWORDS_KEY;
        /*
         * As tags de remarketing não podem ser associadas a informações pessoais de 
         * identificação nem inseridas em páginas relacionadas a categorias de confidencialidade. 
         * Veja mais informações e instruções sobre como configurar a tag em: http://google.com/ads/remarketingsetup
         */
        $str   = "<script type='text/javascript'>
            /* <![CDATA[ */
            var google_conversion_id = $key;
            var google_custom_params = window.google_tag_params;
            var google_remarketing_only = true;
            /* ]]> */
            </script>
            <script type='text/javascript' src='//www.googleadservices.com/pagead/conversion.js'>
            </script>
            <noscript>
            <div style='display:inline;'>
            <img height='1' width='1' style='border-style:none;' alt='' src='//googleads.g.doubleclick.net/pagead/viewthroughconversion/938683318/?value=0&amp;guid=ON&amp;script=0'/>
            </div>
            </noscript>";
        return $this->printstr($print, $str);
    }
    
    private function printstr($print, $str){
        if(false == $print){return $str;}
        echo $str;
    }
    
}
