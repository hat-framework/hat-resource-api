<?php

namespace resource\api\emailMarketing;
class egoiLeadAPI extends \classes\Classes\Object{
    
    private $api = null;
    private $user_ids = array();
    private $data     = array();
    public function __construct() {
        $this->LoadApi();
    }    
            private function LoadApi(){
                if($this->api === null){$this->api = new \Egoi\Api\XmlRpcImpl();}
            }    
    
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
                $this->getListID($listID);
                if(false == $listID){return false;}

                $this->getFormID($formID);
                if(false == $formID){return false;}

                $data_array['apikey'] = EMAIL_MARKETING_EGOI_KEY;
                $data_array['listID'] = $listID;
                $data_array['formID'] = $formID;
                $data_array['formid'] = $formID;
                $data_array['form']   = $formID;
                $result               = $this->api->addSubscriber($data_array);
                return $result;
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
        $this->initArrays();
        
        $this->getListID($listId);
        if(false == $listId){return false;}
        
        $id  = $this->getTagId($tagname);
        if($id == ""){return false;}
        
        $uid = $this->getUsersIds($user_email);
        if(empty($uid) || !is_array($uid)){return false;}
        
        $temp = $this->attachTag($id, $uid, $listId);
        return (isset($temp['RESULT']) && $temp['RESULT'] == "OK");
    }
    
            private function initArrays(){
                $cache = json_decode(\classes\Utils\jscache::get('egoi/userids'),true);
                if(is_array($cache) && empty($this->user_ids)){
                    $this->user_ids = $cache;
                }
                
                if(!empty($this->data)){return;}
                $cache2 = json_decode(\classes\Utils\jscache::get('egoi/tags'),true);
                if(!is_array($cache)){
                    $this->data = $this->api->getTags(array("apikey" => EMAIL_MARKETING_EGOI_KEY));
                    $this->checkLimitMissing($this->data);
                    \classes\Utils\jscache::create('egoi/tags', $this->data);
                }
                else{$this->data = $cache2;}
            }
    
            private function getTagId($tagname){
                $result = $this->findResults($this->data, $tagname);
                if($result !== ""){return $result;}
                
                $temp = $this->api->addTag(array(
                    "apikey" => EMAIL_MARKETING_EGOI_KEY,
                    'name'   => $tagname
                ));
                $this->checkLimitMissing($temp);
                
                if(isset($temp['RESULT'])&&$temp['RESULT']=="OK"&&isset($temp['ID'])){
                    $this->data[] = $temp;
                    \classes\Utils\jscache::create('egoi/tags', $this->data);
                    return $temp["ID"];
                }
                return "";
            }
            
                    private function findResults($data, $tagname){
                        if(empty($data)){return "";}
                        foreach($data['TAG_LIST'] as $tagarray){
                            if($tagarray['NAME'] == $tagname){return "{$tagarray['ID']}";}
                        }
                        return "";
                    }
            
            private function getUsersIds($user_email, $listId){
                if(!is_array($user_email)){$user_email = array($user_email);}
                $uid = array();
                foreach($user_email as $email){
                    $temp = $this->getUserId($email, $listId);
                    if($temp == ""){continue;}
                    $uid[] = $temp;
                }
                if(!empty($this->user_ids)){
                    \classes\Utils\jscache::delete('egoi/userids');
                    \classes\Utils\jscache::create('egoi/userids', $this->user_ids);
                }
                return $uid;
            }        
            
                    private function getUserId($user_email, $listID){
                        if(array_key_exists($user_email, $this->user_ids) && array_key_exists($listID, $this->user_ids[$user_email])){
                            return $this->user_ids[$user_email][$listID];
                        }
                        
                        $result = $this->consultExistentUser($listID, $user_email);
                        $this->user_ids[$user_email][$listID] = (isset($result['subscriber'])&&isset($result['subscriber']['UID'])?$result['subscriber']['UID']:"");
                        
                        if($this->user_ids[$user_email][$listID] == ""){
                            $array = $this->insertUser($user_email);
                            if($array != ""){
                                $this->user_ids[$user_email][$listID] = isset($array['UID'])?$array['UID']:"";
                            }
                        }
                        return $this->user_ids[$user_email][$listID];
                    }
                    
                            private function consultExistentUser($listID, $user_email){
                                $data_array['apikey']           = EMAIL_MARKETING_EGOI_KEY;
                                $data_array['listID']           = $listID;
                                $data_array['subscriber']       = $user_email;
                                $result                         = $this->api->subscriberData($data_array);
                                $this->checkLimitMissing($result);
                                return $result;
                            }

                            private function insertUser($user_email){
                                $data = $this->LoadModel('usuario/login', 'uobj')->selecionar(array('email','user_name'), "email='$user_email'", 1);
                                if(empty($data)){return "";}
                                $array     = array_shift($data);
                                $e         = explode(' ', $array['user_name']);
                                $firstname = array_shift($e);
                                $lastname  = end($e);
                                $arguments = array(
                                    'email'     => $array['email'],
                                    'first_name'=> $firstname,
                                    'last_name' => $lastname
                                );
                                $result = $this->addLead($arguments);
                                $this->checkLimitMissing($result);
                                return $result;
                            }
                            
            public function attachTag($tagid, $usersId, $listId = ""){
                if(!is_array($usersId)){$usersId = array($usersId);}
                if(empty($usersId)){return false;}
                
                $this->getListID($listId);
                $data = $this->api->attachTag(array(
                    "apikey" => EMAIL_MARKETING_EGOI_KEY,
                    'tag'    => $tagid,
                    'target' => $usersId,
                    'type'   => 'subscriber',
                    'listID' => $listId
                ));
                $this->checkLimitMissing($data);
                return $data;
            }         
            
        private function checkLimitMissing($result){
            if(!isset($result['ERROR']) || $result['ERROR'] != "LIST_MISSING "){return;}
            throw new Exception("Limit Missing", '500');
        }

}