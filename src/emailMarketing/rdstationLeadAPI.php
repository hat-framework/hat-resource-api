<?php

namespace resource\api\emailMarketing;
class rdstationLeadAPI{
    
    public $api_url = "http://www.rdstation.com.br/api/1.2/conversions";
    
    public function addLead($data_array) {
        if(RDSTATION_TOKEN == '' || RDSTATION_IDENTIFY == '')return;
        $this->addLeadConversionToRdstationCrm(RDSTATION_TOKEN,RDSTATION_IDENTIFY,$data_array);
    }    
    
/**
 * Como usar:
 *  $this->LoadResource('api', 'api');
 *       $this->rds = new resource\api\rdstation\rdstationLead();
 *       $this->rds->addLead(array('email'=>'joaquimbarbosa@gmail.com','nome'=>'Joaquim Barbosa'));
 * 
 * RD Station - Integrações
 * addLeadConversionToRdstationCrm()
 * Envio de dados para a API de leads do RD Station
 *
 * Parâmetros:
 *     ($rdstation_token) - token da sua conta RD Station ( encontrado em https://www.rdstation.com.br/docs/api )
 *     ($identifier) - identificador da página ou evento ( por exemplo, 'pagina-contato' )
 *     ($data_array) - um Array com campos do formulário ( por exemplo, array('email' => 'teste@rdstation.com.br', 'nome' =>'Fulano') )
 */
private function addLeadConversionToRdstationCrm( $rdstation_token, $identifier, $data_array ) {

  try {
    if (empty($data_array["token_rdstation"]) && !empty($rdstation_token)) { $data_array["token_rdstation"] = $rdstation_token; }
    if (empty($data_array["identificador"]) && !empty($identifier)) { $data_array["identificador"] = $identifier; }
    if (empty($data_array["utmz"])) { $data_array["utmz"] = URL; }
    if (empty($data_array["nome"]) && !empty($data_array['user_name']))$data_array["nome"] = $data_array['user_name'];
    unset($data_array["password"], $data_array["password_confirmation"], $data_array["senha"], 
          $data_array["confirme_senha"], $data_array["confirmkey"], $data_array["captcha"], $data_array["_wpcf7"], 
          $data_array["_wpcf7_version"], $data_array["_wpcf7_unit_tag"], $data_array["_wpnonce"], 
          $data_array["_wpcf7_is_ajax_call"],$data_array["antispam"]);

    if ( !empty($data_array["token_rdstation"]) && !( empty($data_array["email"]) && empty($data_array["email_lead"]) ) ) {
      simple_curl($this->api_url, $data_array);
    }
  } catch (Exception $e) { }
}
}