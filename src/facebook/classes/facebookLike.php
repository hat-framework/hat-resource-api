<?php

class facebookLike{
    
    private $page   = "";
    private $layout = "standard";
    private $action = "like";
    private $faces  = "true";
    private $share  = "true";
    private $width  = "";
    
    private $avalibleLayouts = array('standard','box_count','button_count','button');
    private $avalibleActions = array('like','recommend');
    
    public function setPage($page)    {$this->page   = $page;return $this;}
    public function setLayout($layout){$this->layout = (in_array($layout, $this->avalibleLayouts))?$layout:'standard'; return $this;}
    public function setAction($action){$this->action = (in_array($action, $this->avalibleActions))?$action:'like';     return $this;}
    public function setWidth($width)  {$this->width  = $width;                                                         return $this;}
    public function showFaces($bool)  {$this->faces  = (is_bool($bool) && $bool === false)?'false':'true';             return $this;}
    public function share($bool)      {$this->share  = (is_bool($bool) && $bool === false)?'false':'true';             return $this;}
    
    public function getPage()         {return($this->page === "")?$_SERVER['SERVER_PROTOCOL']."://".$_SERVER['HTTP_HOST']:$this->page;}
        
    public function execute(){
        $page  = $this->getPage();
        $extra = "";
        if($this->width !== ""){$extra = "data-width='$this->width'";}
        echo "<div class='fb-like' data-href='$page' data-layout='$this->layout' data-action='$this->action' data-show-faces='$this->faces' data-share='$this->share' $extra></div>";
    }
    
}
