<?php

namespace resource\api\emailMarketing;
class agendorLeadAPI extends \classes\Classes\Object{
    
    private $api  = "https://api.agendor.com.br/v1";
    private $data = array();
    
    public function setId($id)           {return $this->_set('personId'   , $id);}
    public function setName($name)       {return $this->_set('name'       , $name);}
    public function setDescription($data){return $this->_set('description', $data);}
    public function setCpf($cpf)         {return $this->_set('cpf'        , $cpf);}
    public function setRanking($number)  {return $this->_set('ranking'    , $number);}
    public function setCategory($id)     {return $this->_set('category'   , $id);}
    public function setEmail($email)     {return $this->_append('emails'  , $email);}
    public function setPhone($phone, $type = 'mobile') {
        
        /*Agendor ainda não aceita integração com nono dígito na API*/
        $int = filter_var(str_replace('-', '', $phone), FILTER_SANITIZE_NUMBER_INT);
        if(strlen($int) > 10){
            $int = substr($int, 0, 2) . substr($int, 3, strlen($int)-1) ;
        }
        
        $number = preg_replace('/(\d{2})(\d{4})(\d*)/', '($1) $2-$3', $int);
        return $this->_append('phones', array(
            'number'=>$number, 
            'type'=>$type
        ));
    }
    public function setAddress($cep, $uf, $cidade, $bairro, $rua, $numero, $complemento){
        return $this->_set('address', array(
            "postalCode"    => $cep,
            "state"         => $uf,
            "city"          => $cidade,
            "district"      => $bairro,
            "streetName"    => $rua,
            "streetNumber"  => $numero,
            "additionalInfo"=> $complemento
        ));
    }    
    
    public function update(){
        
    }
    
    public function syncronize(){
        return $this->executeCurl("$this->api/people", $this->data, $type = 'POST');
    }
    
    public function addLead() {
        return $this->executeCurl("$this->api/people", $this->data, $type = 'POST');
    }
    
            private function executeCurl($url, $post, $type = 'POST'){
                
                $token = AGENDOR_TOKEN;
                $ch     = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_HEADER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                if($type == 'POST'){curl_setopt($ch, CURLOPT_POST, TRUE);}
                else{curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);}
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    "Content-Type: application/json",
                    "Authorization: Token $token"
                ));

                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
            }
            
    public function getData(){
        return $this->data;
    }
            
    private function _set($key, $val){
        $this->data[$key] = $val;
        return $this;
    }
    private function _append($key, $val){
        if(!isset($this->data[$key])){$this->data[$key] = array();}
        $this->data[$key][] = $val;
        return $this;
    }
}