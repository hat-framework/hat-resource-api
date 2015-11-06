<?php

namespace resource\api\emailMarketing;
class egoiLeadAPI{
    
    public function addLead($data_array, $listID = "", $formID = "") {
        if(!defined('EMAIL_MARKETING_EGOI_KEY')    || EMAIL_MARKETING_EGOI_KEY == ''){return;}
        if($listID == "" && $formID == ""){
            $url = $this->getURL();
            if(false !== $url){
                $this->addLeadHtml($data_array, $listID, $formID);
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
    
            private function addLeadHtml($data_array, $listID = "", $formID = "", $client = ""){

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
                simple_curl($url, $arr);
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
                

    public function addUserTag($tagname, $user_email, $listId = ""){
        if(!defined('EMAIL_MARKETING_EGOI_KEY')    || EMAIL_MARKETING_EGOI_KEY == ''){return;}
        $this->getListID($listId);
        if(false == $listId){return false;}
        $id  = $this->getTagId($tagname);
        $uid = $this->getUserId($user_email, $listId);
        if($uid == ""){return false;}

        $api    = new \Egoi\Api\SoapImpl();
        $temp   = $api->attachTag(array(
            "apikey" => EMAIL_MARKETING_EGOI_KEY,
            'tag'    => $id,
            'target' => array($uid),
            'type'   => 'subscriber',
            'listID' => $listId
        ));
        return (isset($temp['RESULT']) && $temp['RESULT'] == "OK");
    }
    
            private function getTagId($tagname){
                $api    = new \Egoi\Api\SoapImpl();
                $result = $api->getTags(array("apikey" => EMAIL_MARKETING_EGOI_KEY));
                foreach($result['TAG_LIST'] as $tagarray){
                    if($tagarray['NAME'] == $tagname){return "{$tagarray['ID']}";}
                }
                $temp = $api->addTag(array(
                    "apikey" => EMAIL_MARKETING_EGOI_KEY,
                    'name'   => $tagname
                ));
                return (isset($temp['RESULT'])&&$temp['RESULT']=="OK"&&isset($temp['ID']))?$temp["ID"]:"";
            }

            private function getUserId($user_email, $listID){
                $api    = new \Egoi\Api\SoapImpl();
                $data_array['apikey']     = EMAIL_MARKETING_EGOI_KEY;
                $data_array['listID']     = $listID;
                $data_array['subscriber'] = $user_email;
                $result = $api->subscriberData($data_array);
                return (isset($result['subscriber'])&&isset($result['subscriber']['UID'])?$result['subscriber']['UID']:"");
            }
    
}