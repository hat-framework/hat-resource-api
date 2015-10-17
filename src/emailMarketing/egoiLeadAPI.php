<?php

namespace resource\api\emailMarketing;
class egoiLeadAPI{
    
    public function addLead($data_array, $listID = "", $formID = "") {
        if(!defined('EMAIL_MARKETING_EGOI_KEY')    || EMAIL_MARKETING_EGOI_KEY == ''){return;}
        if($listID == ""){
            if(!defined('EMAIL_MARKETING_EGOI_LISTID') || EMAIL_MARKETING_EGOI_LISTID == ''){return;}
            $listID = EMAIL_MARKETING_EGOI_LISTID;
        }
        
        if($formID == ""){
            if(!defined('EMAIL_MARKETING_EGOI_FORMID') || EMAIL_MARKETING_EGOI_FORMID == ''){return;}
            $formID = EMAIL_MARKETING_EGOI_FORMID;
        }
        $api    = new \Egoi\Api\XmlRpcImpl();
        $data_array['apikey'] = EMAIL_MARKETING_EGOI_KEY;
        $data_array['listID'] = $listID;
        $data_array['formID'] = $formID;
        //print_rh($data_array);
        return $api->addSubscriber($data_array);
    }    
    
    
}