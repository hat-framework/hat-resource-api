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
    
    public function editLead($user_email, $data_array, $listID = ""){
        if(!defined('EMAIL_MARKETING_EGOI_KEY')    || EMAIL_MARKETING_EGOI_KEY == ''){return;}
        if(empty($data_array)){return $this->setErrorMessage("Dados enviados para o usuário $user_email estão vazios!");}
        
        $this->getListID($listID);
        if(trim($listID) == ""){return $this->setErrorMessage("ListID não encontrada:'$listID'");}
        
        $vars = $this->getVars($data_array, $listID);
        $vars['listID'] = $listID;
        $vars['apikey'] = EMAIL_MARKETING_EGOI_KEY;
        
        $uid = $this->getUserId($user_email, $listID);
        if(trim($uid) == ""){return $this->setErrorMessage("UserId não encontrado: usuário '$user_email', lista '$listID'");}
        $vars['subscriber'] = $uid;
        
        $result  = $this->api->editSubscriber($vars);
        if(isset($result['ERROR']) && $result['ERROR'] !=  ""){return $this->setErrorMessage("Erro ao editar o inscrito no E-Goi: {$result['ERROR']}");}
        return true;
    }
            private $field_array = array();
            private function getVars($data_array, $listID){
                if(empty($this->field_array)){$this->field_array = $this->getFieldArray($listID);}
                $list = $this->field_array[$listID];
                if(empty($list)){return $data_array;}
                $out  = array();
                foreach($data_array as $name => $val){
                    $this->getLine($name,$list, $out,$val);
                }
                return $out;
            }
            
                    private function getLine($name,$list, &$out,$val){
                        if(!isset($list[$name])){
                            $out[$name] = $val;
                            return;
                        }
                        $tmpname = $this->_getListCacheName($list[$name]);
                        $temp    = \classes\Utils\jscache::get($tmpname);
                        if($temp != ""){
                            $var = json_decode($temp,true);
                            if(!array_key_exists($val, $var)){return;}
                            $val = $var[$val];
                        }
                        $out["extra_{$list[$name]}"] = $val;
                    }
            
    public function addLead($data_array, $listID = "", $formID = "") {
        if(!defined('EMAIL_MARKETING_EGOI_KEY')    || EMAIL_MARKETING_EGOI_KEY == ''){return;}
        $url = $this->getURL();
        if(false !== $url){$bool = $this->addLeadHtml($data_array, $listID, $formID);}
        if($listID == "" && $formID == ""){return $bool;}
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
        if(!defined('EMAIL_MARKETING_EGOI_KEY')    || EMAIL_MARKETING_EGOI_KEY == ''){return $this->setErrorMessage(
            "Constante EMAIL_MARKETING_EGOI_KEY não definida!"
        );}
        $this->initArrays();
        
        $this->getListID($listId);
        if(false == $listId){return $this->setErrorMessage("Lista $listId não encontrada!");}
        
        $id  = $this->getTagId($tagname);
        if($id == ""){return $this->setErrorMessage("Tag $tagname não encontrada!");}
        
        $uid = $this->getUsersIds($user_email, $listId);
        if(empty($uid) || !is_array($uid)){return $this->setErrorMessage("UserId não encontrado: usuário '$user_email', lista '$listId'");}
        
        $temp = $this->attachTag($id, $uid, $listId);
        if($temp === false){return $this->setErrorMessage("Erro ao associar a tag ao usuário!");}
         if(isset($temp['ERROR']) && $temp['ERROR'] !=  ""){$this->setErrorMessage("Erro ao enviar tag para o E-Goi: {$temp['ERROR']}");}
        return (isset($temp['RESULT']) && $temp['RESULT'] == "OK");
    }
    
            private function initArrays(){
                $this->getCacheArray();
                if(!empty($this->data)){return;}
                $cache2 = json_decode(\classes\Utils\jscache::get('egoi/tags'),true);
                if(!is_array($cache2)){
                    $this->getTagsFromEgoi();
                }
                else{$this->data = $cache2;}
            }
            
                    private function getCacheArray(){
                        $cache = json_decode(\classes\Utils\jscache::get('egoi/userids'),true);
                        if(!is_array($cache) || !empty($this->user_ids)){return false;}
                        foreach($cache as $email => $lists){
                            foreach($lists as $lcode => $lval){
                                if(trim($lval) != ""){continue;}
                                unset($cache[$email][$lcode]);
                                if(!empty($cache[$email])){continue;}
                                unset($cache[$email]);
                            }
                        }
                        $this->user_ids = $cache;
                    }
            
                    private function getTagsFromEgoi(){
                        $this->data = $this->api->getTags(array("apikey" => EMAIL_MARKETING_EGOI_KEY));
                        $this->checkLimitMissing($this->data);
                        \classes\Utils\jscache::create('egoi/tags', $this->data);
                    }
    
            private function getTagId($tagname){
                $result = $this->findResults($this->data, $tagname);
                if($result !== ""){return $result;}
                
                $temp = $this->createEgoiTag($tagname);
                $res  = $this->checkError($temp, $tagname);
                if(false == $res){return false;}
                if(true !== $res){return $res;}
                
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
                    
                    private function createEgoiTag($tagname){
                        $temp = $this->api->addTag(array(
                            "apikey" => EMAIL_MARKETING_EGOI_KEY,
                            'name'   => $tagname
                        ));
                        $this->checkLimitMissing($temp);
                        return $temp;
                    }
                    
                    private function checkError($temp, $tagname){
                        if(!isset($temp['ERROR'])){return true;}
                        if($temp["ERROR"] == "TAG_ALREADY_EXISTS"){
                            $this->getTagsFromEgoi();
                            $result = $this->findResults($this->data, $tagname);
                            if($result !== ""){return $result;}
                            return true;
                        }
                        return $this->setErrorMessage($temp['ERROR']);
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
                            if(trim($this->user_ids[$user_email][$listID]) != ""){
                                return $this->user_ids[$user_email][$listID];
                            }
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
        
    private $cacheFields  = 'egoi/fieldids';
    private $cacheLists   = 'egoi/list';
    private $avaibleTypes = array('data','texto','telefone','telemovel','fax','numero','email','lista');
    public function getFieldID($fieldname, $type = 'texto', $listOptions = array(), $listID = ""){
        if(!in_array($type, $this->avaibleTypes)){return $this->setErrorMessage("O campo $fieldname não pode ser criado pois o tipo dele não existe!");}
        $this->getListID($listID);
        $fields = $this->getFieldArray($listID, $fieldname);
        if(!is_array($fields)){return $fields;}
        
        $array = $this->getSendArray($listID,$fieldname,$type,$listOptions);
        return $this->saveField($fieldname, $array, $type, $listOptions, $fields, $listID);
    }
    
            private function getFieldArray($listID, $fieldname = ""){
                $fields = json_decode(\classes\Utils\jscache::get($this->cacheFields),true);
                if(!is_array($fields)){
                    $fields = $this->getEgoiFields($listID);
                    if(!is_array($fields)){
                        $fields          = array();
                        $fields[$listID] = array();
                    }
                }
                if($fieldname != ""){
                    if(isset($fields[$listID]) && isset($fields[$listID][$fieldname])){return $fields[$listID][$fieldname];}
                }
                return $fields;
            }
            
                    private function getEgoiFields($listID){
                        $fields = $this->api->getExtraFields(array(
                            "apikey" => EMAIL_MARKETING_EGOI_KEY,
                            'listID' => $listID,
                            'start'  => 0,
                            'limit'  => 1000
                        ));
                        if(!is_array($fields) || isset($fields['ERROR'])){return $this->setErrorMessage("Falha ao recuperar fields do egoi: ".$fields['ERROR']);}
                        if(!isset($fields['extra_fields'])){return $this->setErrorMessage("Falha ao recuperar fields do egoi: Erro desconhecido!");}
                        $out = array();
                        foreach($fields['extra_fields'] as $key => $f){
                            $out[$listID][$f['NAME']] = $key;
                        }
                        \classes\Utils\jscache::delete($this->cacheFields);
                        \classes\Utils\jscache::create($this->cacheFields, $out);
                        return $out;
                    }
    
            private function getSendArray($listID,$fieldname,$type){
                $array = array(
                    "apikey"        => EMAIL_MARKETING_EGOI_KEY,
                    'listID'        => $listID,
                    'name'          => $fieldname,
                    'type'          => $type
                );
                return $array;
            }
    
            private function saveField($fieldname, $array, $type, $listOptions, $fields, $listID){
                //if($type === 'lista'){$array['type'] = 'text';}
                $data  = $this->api->addExtraField($array);
                $this->checkLimitMissing($data);
                $this->checkListType($type, $data, $listOptions, $array);
                return $this->saveFieldCache($fields, $listID, $fieldname, $data);
            }
            
                    private function checkListType($type, &$data, $listOptions, $array){
                        if($type == 'lista' && isset($data['NEW_ID'])){
                            $array['fieldID']      = $data['NEW_ID'];
                            $array['fields_values']= $this->getListOption($listOptions);
                            safeUnset(array('name','type'), $array);
                            $data2  = $this->api->editExtraField($array);
                            $this->checkLimitMissing($data2);
                            if(!isset($data2['NEW_VALUES'])){return $this->setErrorMessage("Não foi possível salvar os itens da lista!");}
                            $data['fields_values'] = $data2['NEW_VALUES'];
                        }
                    }
            
                            private function getListOption($listOptions){
                                $out = array();
                                foreach($listOptions as $key => $option){
                                    if(is_numeric($key)){$key = "a$key";}
                                    $out[$key] = GetPlainName($option, true, true, false);
                                }
                                return $out;
                            }
    
                    private function saveFieldCache($fields, $listID, $fieldname, $data){
                        if(!isset($data['NEW_ID'])){return $this->setErrorMessage("Falha ao criar novo campo");}
                        $fields[$listID][$fieldname] = $data['NEW_ID'];
                        if(!empty($fields)){
                            \classes\Utils\jscache::delete($this->cacheFields);
                            \classes\Utils\jscache::create($this->cacheFields, $fields);
                        }
                        if(isset($data['fields_values']) && is_array($data['fields_values']) && !empty($data['fields_values'])){
                            \classes\Utils\jscache::create($this->_getListCacheName($data['NEW_ID']), $data['fields_values']);
                        }
                            
                        return $fields[$listID][$fieldname];
                    }
                    
    private function _getListCacheName($id){
        return "$this->cacheLists/l{$id}";
    }

}