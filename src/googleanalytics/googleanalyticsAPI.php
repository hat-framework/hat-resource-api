<?php

class googleanalyticsAPI extends \classes\Interfaces\resource{
    
    public function startAnalytics($key = '', $print = true){
        static $loaded = false;
        if($loaded === true){return;}
        else{$loaded = true;}
        if(usuario_loginModel::IsWebmaster()){return;}
        if(strstr($_SERVER['HTTP_HOST'], ".") !== false){return;}
        
        if($key === ""){
            if(!defined('API_GA_KEY')){return;}
            $key = API_GA_KEY;
        }
        
        $u     = $_SERVER['SERVER_NAME'] ;
        $cod   = \usuario_loginModel::CodUsuario();
        $extra = ($cod !== 0)?"ga('set', '&uid', '$cod');":"";
        $pname = $this->LoadModel('usuario/perfil', 'perf')->getField(usuario_loginModel::CodPerfil(), 'usuario_perfil_nome');
        
        $str   = "<script type='text/javascript'>".
             "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){".
             "(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),".
             "m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)".
             "})(window,document,'script','//www.google-analytics.com/analytics.js','ga');".
             "ga('create', '$key', '$u'); ga('require', 'displayfeatures'); $extra ga('send', 'pageview');".
             "_setCustomVar(1,'perfil','$pname')".
             "</script>";
        if($print){echo $str;}
        else{return $str;}
    }
    
}
