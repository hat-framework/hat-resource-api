<?php

require_once '../../autoload.php';
require_once '../../../../vendor/autoload.php';

$uploadFile = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR.'empty.html'; // File to upload, we'll use the S3 class since it exists
$filename   = 'myFolder/mySampleFile';
$aws = new lib\aws\awsS3Manager();

//$aws->uploadDirectory(dirname(__FILE__), 'testFolder');
if(false === $aws->setFile($filename, $uploadFile)){
    die($aws->getErrorMessage() . " - Falha no setFile");
}

$file = $aws->getFile($filename);
if(false === $file){
    die($aws->getErrorMessage() . " - Falha no getFile");
}

if(false === $aws->existsFile($filename)){
    die($aws->getErrorMessage() . " - Arquivo $filename não existe!");
}

$info = $aws->getFileInfo("myFolder/");
if($info === false){
    die("falha no teste! arquivo $filename deveria retornar informações, pois deveria existir!". $aws->getErrorMessage());
}
//print_r($info);

$info2 = $aws->getFileInfo('dfasdfsa');
if($info2 !== false){
    die("falha no teste! Arquivo 'dfasdfsa' não deveria existir!");
}
//print_r($info2);
$folder = $aws->listFolder("myFolder/");
if($folder !== array('myFolder/', 'myFolder/mySampleFile')){
    die("A quantidade de arquivos na pasta não bate com a quantidade esperada");
}


if(false === $aws->deleteFile($filename)){
    die($aws->getErrorMessage() . "- Erro ao apagar arquivo!");
}

echo "done!";