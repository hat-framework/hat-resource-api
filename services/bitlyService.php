<?php
/**
 * Created by PhpStorm.
 * User: davidson
 * Date: 15/03/16
 * Time: 15:07
 */

if (!isset($_REQUEST['url'])) {
    die(json_encode(array( 'success' => false )));
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/init.php";
$obj = new \classes\Classes\Object();

$bitly = $obj->LoadResource('api', 'api')->LoadApiClass('bitly/bitly');
$url = $bitly->getCompressedLink($_REQUEST['url']);
die(json_encode(!$url ? array( 'success' => false ) : array( 'success' => true, 'url' => $url )));