<?php

if(!defined('CURRENT_CANONICAL_PAGE')){define('CURRENT_CANONICAL_PAGE', "");}
class googleanalyticsAPI extends \classes\Interfaces\resource{
    
    public function startAnalytics($print = true, $angularApp = array()){
        static $loaded = false;
        if($loaded === true){return;}
        else{$loaded = true;}
        if(!defined('API_GA_KEY')){return;}
        if(usuario_loginModel::IsWebmaster()){return;}
        $metrics = $this->getMetrics();
        $key     = API_GA_KEY;
        $u       = $_SERVER['SERVER_NAME'];
        $send    = (!is_array($angularApp) || !in_array(CURRENT_CANONICAL_PAGE, $angularApp))?"ga('send', 'pageview');":"";
        $str     = "<script type='text/javascript'>".
             "(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){".
             "(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),".
             "m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)".
             "})(window,document,'script','//www.google-analytics.com/analytics.js','ga');".
             "ga('create', '$key', '$u'); ga('require', 'displayfeatures'); $metrics $send".
             "</script>";
        return $this->printstr($print, $str);
    }
    
    private $metrics = array();
    
    public function getMetrics(){
        $cod   = \usuario_loginModel::CodUsuario();
        if($cod !== 0){$this->addMetric('dimension1', $cod);}

        $cod2   = usuario_loginModel::CodPerfil();
        if($cod2 !== 0){$this->addMetric('dimension2', $cod2);}
        
        if(empty($this->metrics)){return;}
        $var = json_encode($this->metrics);
        $this->metrics = array();
        return "ga('set', $var);";
    }
    
    public function addMetric($name, $val){
        $this->metrics[$name] = $val;
        return $this;
    }
    
    
    /*
     * 
     ga('set', {
  'dimension5': 'custom dimension data',
  'metric5': 'custom metric data'
});
     * 
     */
    
    public function abTest($keys, $print = true){
        if(strstr($_SERVER['HTTP_HOST'], ".") === false){return false;}
        if(!is_array($keys) || empty($keys)){return;}
        $page = CURRENT_MODULE.'/'.CURRENT_CONTROLLER.'/'.CURRENT_ACTION;
        if(!isset($keys[$page])){return;}
        $key = $keys[$page];
        $str = "<!-- Google Analytics Content Experiment code -->
                <script>function utmx_section(){}function utmx(){}(function(){var
                k='$key',d=document,l=d.location,c=d.cookie;
                if(l.search.indexOf('utm_expid='+k)>0)return;
                function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
                indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.
                length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write(
                '<sc'+'ript src=\"'+'http'+(l.protocol=='https:'?'s://ssl':
                '://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+
                '&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().
                valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
                '\" type=\"text/javascript\" charset=\"utf-8\"><\/sc'+'ript>')})();
                </script><script>utmx('url','A/B');</script>
                <!-- End of Google Analytics Content Experiment code -->";
       
        return $this->printstr($print, $str);
    }
    
    private function printstr($print, $str){
        if(false == $print){return $str;}
        echo $str;
    }
    
}
