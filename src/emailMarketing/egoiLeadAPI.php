<?php

namespace resource\api\emailMarketing;
class egoiLeadAPI{
    
    public function addLead($data_array, $listID = "", $formID = "") {
        if($listID == "" && $formID == ""){
            $url = $this->getURL();
            if(false !== $url){
                $bool = $this->addLeadHtml($data_array, $listID, $formID);
                if(true === $bool){return true;}
            }
        }
        return $this->addLeadAPI($data_array, $listID, $formID);
    }    
    
            private function addLeadAPI($data_array, $listID = "", $formID = ""){
                if(!defined('EMAIL_MARKETING_EGOI_KEY')    || EMAIL_MARKETING_EGOI_KEY == ''){return;}
        
                $this->getListID($listID);
                if(false == $listID){return false;}

                $this->getFormID($formID);
                if(false == $formID){return false;}

                $api    = new \Egoi\Api\SoapImpl();
                $data_array['apikey'] = EMAIL_MARKETING_EGOI_KEY;
                $data_array['listID'] = $listID;
                $data_array['formID'] = $formID;
                $data_array['formid'] = $formID;
                $data_array['form']   = $formID;
                //print_rh($data_array);
                return $api->addSubscriber($data_array);
            }
    
    public function addLeadHtml($data_array, $listID = "", $formID = "", $client = ""){
        
        $nameField = $mailField = "";
        
        $url = $this->getURL();
        if(false === $url){return false;}
        
        $this->getListID($listID);
        if(false == $listID){return false;}
        
        $this->getFormID($formID);
        if(false == $formID){return false;}
        
        $this->getClient($client);
        if(false == $client){return false;}
        
        $this->getNameField($nameField);
        if(false == $nameField){return false;}
        
        $this->getEmailField($mailField);
        if(false == $mailField){return false;}
        
        $arr['lista']    = $listID;
        $arr['formid']   = $formID;
        $arr['cliente']  = $client;
        $arr['lang']     = 'br';
        $arr[$nameField] = $data_array['first_name'];
        $arr[$mailField] = $data_array['email'];
        echoBr(simple_curl($url, $arr));
        return true;
    }
            private function getURL(){
                if(!defined('EMAIL_MARKETING_EGOI_URL') || EMAIL_MARKETING_EGOI_URL == ''){return false;}
                return EMAIL_MARKETING_EGOI_URL;
            }
            
            private function getListID(&$listID){
                if($listID !== ""){return;}
                if(!defined('EMAIL_MARKETING_EGOI_LISTID') || EMAIL_MARKETING_EGOI_LISTID == ''){$listID = false; return;}
                $listID = EMAIL_MARKETING_EGOI_LISTID;
            }
            
            private function getFormID(&$formID){
                if($formID !== ""){return;}
                if(!defined('EMAIL_MARKETING_EGOI_FORMID') || EMAIL_MARKETING_EGOI_FORMID == ''){return;}
                $formID = EMAIL_MARKETING_EGOI_FORMID;
            }
            
            private function getClient(&$client){
                if($client !== ''){return;}
                if(!defined('EMAIL_MARKETING_EGOI_CLIENT') || EMAIL_MARKETING_EGOI_CLIENT == ''){return;}
                $client = EMAIL_MARKETING_EGOI_CLIENT;
            }
            
            private function getNameField(&$nameField){
                if($nameField !== ""){return;}
                if(!defined('EMAIL_MARKETING_EGOI_NAME_FIELD') || EMAIL_MARKETING_EGOI_NAME_FIELD == ''){return;}
                $nameField = EMAIL_MARKETING_EGOI_NAME_FIELD;
            }
            
            private function getEmailField(&$emailField){
                if($emailField !== ""){return;}
                if(!defined('EMAIL_MARKETING_EGOI_EMAIL_FIELD') || EMAIL_MARKETING_EGOI_EMAIL_FIELD == ''){return;}
                $emailField = EMAIL_MARKETING_EGOI_EMAIL_FIELD;
            }
    
    
}