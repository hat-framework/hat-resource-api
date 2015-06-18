<?php

namespace resource\api\aws;
require_once dirname(__FILE__) .'/functions.php';
class awsS3Manager{
    
    private $s3     = null;
    private $bucket = "";
    private $error  = "";
    
    public function getErrorMessage(){
        return $this->error;
    }
    
    public function __construct() {
        $this->s3     = new \S3(AWS_ACCESS_KEY, AWS_SECRET_KEY);
        $this->bucket = AWS_DEFAULT_BUCKET;
        $this->s3->setExceptions(true);
        $this->s3->setSSL(false);
    }
    
    /**
     * Send some file to AWS
     * @param string $name file_name
     * @param string $location local file location
     * @return boolean
     */
    public function setFile($name, $location){
        try{
            return ($this->s3->putObjectFile($location, $this->bucket, $name));
        } catch (Exception $ex) {
            return $this->exception($ex);
        }
    }
    
    /**
     * Get some file from AWS
     * @param string $name file_name
     * @param string $saveTo [optional] if informed 
     * @return mixed 
     * false if file not exists or have an error, 
     * true if file exists exists and $saveTo == ''
     * content_file if $saveTo != '' and no error ocurr
     */
    public function getFile($name, $saveTo = ""){
        try{
            $saveTo = ($saveTo === "")?false:$saveTo;
            $obj    = ($this->s3->getObject($this->bucket, $name, $saveTo));
            if(false === $saveTo){
                $obj = (array)$obj;
                if(trim($obj["error"]) == ""){return $obj['body'];}
                $this->error = $obj["error"];
                return false;
            }
            return true;
        } catch (\Exception $ex) {
            return $this->exception($ex);
        }
    }
    
    private function exception($ex){
        $this->error = 'Código: '.$ex->getCode(). " - Msg:".$ex->getMessage();
        return false;
    }
    
    /**
     * delete some AWS file if exists
     * @param string $name the filename
     * @return boolean: true if file is dropped, false otherwise
     */
    public function deleteFile($name){
        try{
            if (true === $this->s3->deleteObject($this->bucket, $name)) {
                return true;
            }else{
                $this->error = "Erro ao apagar arquivo $name!";
                return false;
            }
        } catch (\Exception $ex) {
            return $this->exception($ex);
        }
        
    }
    
    /**
     * check if file exists in AWS
     * @param string $name the filename
     * @return boolean: true if file exists, false otherwise
     */
    public function existsFile($name){
        return ($this->getFileInfo($name)!==false);
    }
    
    /**
     * check if file exists in AWS
     * @param string $name the filename
     * @return boolean: true if file exists, false otherwise
     */
    public function getFileInfo($name){
        try{
            $info = $this->s3->getObjectInfo($this->bucket, $name);
            if($info == ""){
                $this->error = "Nenhuma informação encontrada do arquivo '$name'";
                return false;
            }
            return $info;
        } catch (\Exception $ex) {
            return $this->exception($ex);
        }
    }
    
    /**
     * lista todos os arquivos dentro de uma pasta
     * @param string $foldername name of your aws folder
     * @return array um array contendo todos os arquivos presentes naquela pasta
     */
    public function listFolder($foldername, $details = false){
        try{
            $arr = $this->s3->getBucket($this->bucket, $foldername);
            if($details || empty($arr)){return $arr;}
            $out = array();
            foreach($arr as $a){
                $out[] = $a['name'];
            }
            return $out;
        } catch (\Exception $ex) {
            return $this->exception($ex);
        }
    }
    
    public function dropFileWithoutIntegrity($name, $maxsize = 20){
        $info = $this->getFileInfo($name);
        if(false === $info){return false;}
        
        if($info['size'] <= $maxsize){
            $this->deleteFile($name);
            $this->error = "File $name é menor do que $maxsize";
            return false;
        }
        return true;
    }
}