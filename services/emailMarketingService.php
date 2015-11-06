<?php

if(!isset($_GET['method'])){
    $message = array(
        'status' => '0', 'erro' => "você deve informar qual a ação da API que você deseja chamar"
    );
    die(json_encode($message));
}
require_once $_SERVER['DOCUMENT_ROOT']."/init.php";
$obj      = new \classes\Classes\Object();
$location = classes\Classes\Registered::getResourceLocation("api");
$dir      = BASE_DIR . $location ."/src/emailMarketing";
getTrueDir($dir);
$arquivos = $obj->LoadResource('files/dir', 'dobj')->getArquivos($dir);
$api      = $obj->LoadResource('api', 'api');

$method   = filter_input(INPUT_GET, 'method');
unset($_GET['method']);
$messages = array('status'=>'1');
foreach ($arquivos as $arq){
    $arq  = str_replace("API.php", '', $arq);
    $obj2 = $api->LoadApiClass("emailMarketing/$arq");
    if(!method_exists($obj2, $method)){continue;}
    if(call_user_func_array(array($obj2, $method), $_GET) === false){
        $messages['erro']   = $obj->getErrorMessage();
        $messages['status'] = '0';
    }
}
die(json_encode($messages));