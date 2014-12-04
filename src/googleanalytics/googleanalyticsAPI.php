<?php

class googleanalyticsAPI extends \classes\Interfaces\resource{
    
    public function startAnalytics($key = '', $print = true){
        static $loaded = false;
        if($loaded === true){return;}
        else{$loaded = true;}
        //if(usuario_loginModel::IsWebmaster()){return;}
        if($key === ""){
            if(!defined('API_GA_KEY')){return;}
            $key = API_GA_KEY;
        }
        //$url = \classes\Classes\Registered::getResourceLocationUrl('api')."/src/googleanalytics/ga.js";
        //$this->LoadResource("html", 'html')->LoadJs($url);
        
        //$u = $_SERVER['SERVER_NAME'] ;
        $cod   = \usuario_loginModel::CodUsuario();
        $extra = ($cod !== 0)?"ga('set', '&uid', '$cod');":"";
        
        $codp  = usuario_loginModel::CodPerfil();
        $pname = $this->LoadModel('usuario/perfil', 'perf')->getField($codp, 'usuario_perfil_nome');
        
        $str = "<script type='text/javascript'>".
             "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){".
             "(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),".
             "m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)".
             "})(window,document,'script','//www.google-analytics.com/analytics.js','ga');".
             "ga('create', '$key', 'auto'); ga('require', 'displayfeatures'); $extra ga('send', 'pageview');".
             "_setCustomVar(1,'perfil','$pname')".
             "</script>";
        if($print){echo $str;}
        else{return $str;}
    }
    
}
