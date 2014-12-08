<?php

class facebookComments{
    
    private $page         = "";
    private $numPosts     = 10;
    private $colorScheme  = 'light';
    
    private $minNumPosts  = 1;
    private $validSchemes = array('light', 'dark');
    
    public function setPage($page){
        $this->page = $page;
        return $this;
    }
    public function getPage(){
        return($this->page === "")?$_SERVER['SERVER_PROTOCOL']."://".$_SERVER['HTTP_HOST']:$this->page;
    }    
    public function setNumPosts($num){
        if(is_numeric($num) && $num >= $this->minNumPosts){
            $this->numPosts = $num;
        }
        return $this;
    }
    public function getNumPosts(){
        return $this->numPosts;
    }
    
    public function setColorScheme($scheme){
        if(in_array($scheme, $this->validSchemes)){
            $this->colorScheme = $scheme;
        }
        return $this;
    }
    public function getColorScheme(){
        return $this->colorScheme;
    }
    
    public function execute(){
        $page  = $this->getPage();
        echo "<div class='fb-comments' data-href='$page' data-numposts='$this->numPosts' data-colorscheme='$this->colorScheme'></div>";
    }
    
}
