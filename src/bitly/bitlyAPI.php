<?php

/**
 * Created by PhpStorm.
 * User: davidson
 * Date: 15/03/16
 * Time: 15:21
 */
if (!defined("API_BITLY_APPSECRET")) define("API_BITLY_APPSECRET", "");

class bitlyAPI extends \classes\Interfaces\resource {
    public function __construct() {
        $this->dir = dirname(__FILE__);
        parent::__contruct();
        $this->LoadResourceFile("/classes/bitly.php");
    }

    /**
     * Realiza compressão de URL
     * @param $longUrl - URL original
     * @return bool
     */
    public function getCompressedLink($longUrl) {

        $params = array();
        $params['access_token'] = API_BITLY_APPSECRET;
        $params['longUrl'] = $longUrl;
        $params['domain'] = API_BITLY_DOMAIN;
        
        $results = bitly_get('shorten', $params);

        if ($results['status_code'] != 200)
            return false;

        return $results['data']['url'];
    }
}
