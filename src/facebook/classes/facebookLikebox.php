<?php

class facebookLikebox{
    
    private $page   = "";
    private $faces  = "true";
    private $header = "true";
    private $stream = "false";
    private $border = "true";
    private $color = "light";
    
    private $avalibleColors = array('light','dark');
    public function setPage($page)   {$this->page   = $page;return $this;}
    public function setColor($color) {$this->color  = (in_array($color, $this->avalibleColors))?$color:'light'; return $this;}
    public function showFaces($bool) {$this->faces  = (is_bool($bool) && $bool === false)?'false':'true';       return $this;}
    public function showHeader($bool){$this->header = (is_bool($bool) && $bool === false)?'false':'true';       return $this;}
    public function showStream($bool){$this->header = (is_bool($bool) && $bool === false)?'false':'true';       return $this;}
    public function showBorder($bool){$this->border = (is_bool($bool) && $bool === false)?'false':'true';       return $this;}
    
    public function getPage()         {return($this->page === "")?API_FACEBOOK_FANPAGE:$this->page;}
        
    public function execute(){
        if(!defined('API_FACEBOOK_FANPAGE')){return;}
        $page = $this->getPage();
        echo "<div class='fb-like-box' 
                   data-href='$page' 
                   data-colorscheme='$this->color' 
                   data-show-faces='$this->faces' 
                   data-header='$this->header' 
                   data-stream='$this->stream' 
                   data-show-border='$this->border'>
              </div><div id='fb-root'></div>";
    }
    
}
