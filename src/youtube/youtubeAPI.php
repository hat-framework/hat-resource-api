<?php
class youtubeAPI extends \classes\Interfaces\resource{
    
    private $layouts = array('full'  , 'default');
    private $themes  = array('dark'  , 'default');
    private $counts  = array('hidden', 'default');
    private $theme  = 'default';
    private $layout = 'full';
    private $count  = 'default';
    
    
    public function setCount($count)  {$this->count  = (in_array($count , $this->counts)) ?$count :'default'; return $this;}
    public function setTheme($theme)  {$this->theme  = (in_array($theme , $this->themes)) ?$theme :'default'; return $this;}
    public function setLayout($layout){$this->layout = (in_array($layout, $this->layouts))?$layout:'default'; return $this;}
    public function setEvent($js, $fnname) {
        $this->eventname = $fnname;
        if(trim($fnname) === ""){return;}
        $this->LoadResourece('html', 'html')->LoadJsFunction($js); 
    }
    
    public function likebutton($print = true){
        if(!defined("API_YT_ID")){return;}
        $str  = "<script src='https://apis.google.com/js/platform.js'></script>";
        $str .= "<div class='g-ytsubscribe' "
                . "data-channelid='".API_YT_ID."' "
                . "data-layout='$this->layout' "
                . "data-count='$this->count' "
                . "data-theme='$this->theme'"
                . "data-onytevent='onYtEvent'>"
                . "</div>";
        if($print){echo $str;}
        return $str;
        
    }
}
