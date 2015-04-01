<?php
class linkedinAPI extends \classes\Interfaces\resource{
    
    private $counter = 'top';
    public function disableCounter(){
        $this->counter = '';
        return $this;
    }
    
    public function likebutton($print = true){
        if(!defined('API_LKD_ID')){return;}
        $var  = "<script src='//platform.linkedin.com/in.js' type='text/javascript'> lang: pt_BR</script>";
        $var .= "<script type='IN/FollowCompany' data-id='".API_LKD_ID."' data-counter='$this->counter'></script>";
        if($print){echo $var;}
        return $var;
    }
}
