<?php

class apiConfigurations extends \classes\Classes\Options{
                
    protected $files   = array(
        
        'api/facebook' => array(
            'title'        => 'Opções do Facebook',
            'descricao'    => 'Configurações do Facebook',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/facebook',
            'visibilidade' => 'admin', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
              
                'API_FACEBOOK_APPID' => array(
                    'name'          => 'API_FACEBOOK_APPID',
                    'label'         => 'Id do aplicativo do Facebook',
                    'type'          => 'varchar',//varchar, text, enum
                ),
                
                'API_FACEBOOK_APPSECRET' => array(
                    'name'          => 'API_FACEBOOK_APPSECRET',
                    'label'         => 'Chave secreta do aplicativo do Facebook',
                    'type'          => 'varchar',//varchar, text, enum
                ),
            )
        ),
        
        'api/ga' => array(
            'title'        => 'Opções do Google Analytics',
            'descricao'    => 'Configurações do Google Analytics',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/ga',
            'visibilidade' => 'webmaster', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                'API_GA_KEY' => array(
                    'name'          => 'API_GA_KEY',
                    'label'         => 'Analytics Identifier',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Chave de acesso ao google analytics',
                    'value'         => '',
                    'value_default' => ''
                ),
                
            )
        ),
        
        'api/aws' => array(
            'title'        => 'Opções do AWS',
            'descricao'    => 'Configurações de acesso do AWS',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/aws',
            'visibilidade' => 'webmaster', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                
                'AWS_ACCESS_KEY' => array(
                    'name'          => 'AWS_ACCESS_KEY',
                    'label'         => 'Access Key',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Chave de acesso ao serviço da amazon',
                    'value'         => '',
                    'value_default' => ''
                ),
                
                'AWS_SECRET_KEY' => array(
                    'name'          => 'AWS_SECRET_KEY',
                    'label'         => 'Chave de acesso privada',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Senha da amazon',
                    'value'         => '',
                    'value_default' => ''
                ),
                
                'AWS_DEFAULT_BUCKET' => array(
                    'name'          => 'AWS_DEFAULT_BUCKET',
                    'label'         => 'Default Bucket name',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Nome do bucket aonde os arquivos do s3 serão salvos',
                    'value'         => '',
                    'value_default' => ''
                ),
                
                'AWS_DEFAULT_HOST' => array(
                    'name'          => 'AWS_DEFAULT_HOST',
                    'label'         => 'Default Hostname',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '.s3.amazonaws.com',
                    'description'   => 'Preencha com BUCKET_NAME.".s3.amazonaws.com"',
                    'value'         => '.s3.amazonaws.com',
                    'value_default' => '.s3.amazonaws.com'
                ),
                
            ),
        ),
        
        'api/rdstation' => array(
            'title'        => 'Opções do RD STATION',
            'descricao'    => 'Configurações de acesso do RD Station',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/rdstation',
            'visibilidade' => 'webmaster', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                
                'RDSTATION_TOKEN' => array(
                    'name'          => 'RDSTATION_TOKEN',
                    'label'         => 'Token de Acesso',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Token de acesso ao serviço da RD Station',
                    'value'         => '',
                    'value_default' => ''
                ), 
                
                'RDSTATION_IDENTIFY' => array(
                    'name'          => 'RDSTATION_IDENTIFY',
                    'label'         => 'identificador de Acesso',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Identificador de acesso ao serviço da RD Station',
                    'value'         => '',
                    'value_default' => 'formulario-finance-e'
                ),
            ),
        ),
        
        'api/olark' => array(
            'title'        => 'Opções do Olark',
            'descricao'    => 'Configurações do Olark',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/olark',
            'visibilidade' => 'webmaster', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                'API_OLARK_KEY' => array(
                    'name'          => 'API_OLARK_KEY',
                    'label'         => 'olark Key',
                    'type'          => 'varchar',//varchar, text, enum
                    'description'   => 'Chave de acesso ao olark',
                ),
                
            )
        )
        
    );
}