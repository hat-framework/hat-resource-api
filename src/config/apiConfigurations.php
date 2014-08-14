<?php

class apiConfigurations extends \classes\Classes\Options{
                
    protected $files   = array(
        
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
                    'label'         => 'Default Bucket name',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '.s3.amazonaws.com',
                    'description'   => 'Preencha com BUCKET_NAME.".s3.amazonaws.com"',
                    'value'         => '.s3.amazonaws.com',
                    'value_default' => '.s3.amazonaws.com'
                ),
                
            ),
        ),
    );
}