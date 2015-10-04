<?php

namespace resource\api\emailMarketing;
class egoiLead{
        
    public function addLead($data_array, $listID = "") {
        if(!defined('EMAIL_MARKETING_EGOI_KEY')    || EMAIL_MARKETING_EGOI_KEY == ''){return;}
        if($listID == ""){
            if(!defined('EMAIL_MARKETING_EGOI_LISTID') || EMAIL_MARKETING_EGOI_LISTID == ''){return;}
            $listID = EMAIL_MARKETING_EGOI_LISTID;
        }
        $api    = new Egoi\Api\XmlRpcImpl();
        $data_array['apikey'] = EMAIL_MARKETING_EGOI_KEY;
        $data_array['listID'] = $listID;
        return $api->addSubscriber($data_array);
    }    
    
}