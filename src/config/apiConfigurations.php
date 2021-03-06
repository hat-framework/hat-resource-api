<?php

class apiConfigurations extends \classes\Classes\Options {
    protected $files = array(

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
            'grupo'        => 'API de Email Marketing',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/rdstation',
            'visibilidade' => 'admin', //'usuario', 'admin', 'webmaster'
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

        'api/agendor' => array(
            'title'        => 'Opções do Agendor',
            'descricao'    => 'Configurações de acesso do Agendor',
            'grupo'        => 'API de Email Marketing',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/agendor',
            'visibilidade' => 'admin', //'usuario', 'admin', 'webmaster'
            'configs'      => array(

                'AGENDOR_TOKEN' => array(
                    'name'          => 'AGENDOR_TOKEN',
                    'label'         => 'Token de Acesso',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Para obter o token de acesso: entre no agendor, vá em menu > Integrações',
                    'value'         => '',
                    'value_default' => ''
                )
            ),
        ),

        'api/egoi' => array(
            'title'        => 'Opções do E-GOI',
            'descricao'    => 'Configurações de acesso do E-GOI',
            'grupo'        => 'API de Email Marketing',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/egoi',
            'visibilidade' => 'admin', //'usuario', 'admin', 'webmaster'
            'configs'      => array(

                'EMAIL_MARKETING_EGOI_KEY' => array(
                    'fieldset'      => 'Integração Geral',
                    'name'          => 'EMAIL_MARKETING_EGOI_KEY',
                    'label'         => 'Token de Acesso',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Token de acesso ao serviço do EGOI',
                    'value'         => '',
                    'value_default' => ''
                ),

                'EMAIL_MARKETING_EGOI_LISTID' => array(
                    'name'          => 'EMAIL_MARKETING_EGOI_LISTID',
                    'label'         => 'ID da Lista de Email Padrão',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Esta lista será utilizada no cadastro',
                    'value'         => '',
                    'value_default' => ''
                ),

                'EMAIL_MARKETING_EGOI_FORMID' => array(
                    'name'          => 'EMAIL_MARKETING_EGOI_FORMID',
                    'label'         => 'ID do formulário de Email Padrão',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Este form irá te auxiliar na automação das mensagens para os seus leads',
                    'value'         => '',
                    'value_default' => ''
                ),

                'EMAIL_MARKETING_EGOI_URL' => array(
                    'fieldset'      => 'Integração via formulário HTML',
                    'name'          => 'EMAIL_MARKETING_EGOI_URL',
                    'label'         => 'Url de integração de formulário avançado',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Pegue uma url do formulário avançado',
                    'value'         => '',
                    'value_default' => ''
                ),

                'EMAIL_MARKETING_EGOI_CLIENT' => array(
                    'name'          => 'EMAIL_MARKETING_EGOI_CLIENT',
                    'label'         => 'Client do formulário avançado',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => '',
                    'value'         => '',
                    'value_default' => ''
                ),

                'EMAIL_MARKETING_EGOI_NAME_FIELD'  => array(
                    'name'          => 'EMAIL_MARKETING_EGOI_NAME_FIELD',
                    'label'         => 'Nome do campo first_name no formulário',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => '',
                    'value'         => '',
                    'value_default' => ''
                ),
                'EMAIL_MARKETING_EGOI_EMAIL_FIELD' => array(
                    'name'          => 'EMAIL_MARKETING_EGOI_EMAIL_FIELD',
                    'label'         => 'Nome do campo email no formulário',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => '',
                    'value'         => '',
                    'value_default' => ''
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
                    'name'        => 'API_OLARK_KEY',
                    'label'       => 'olark Key',
                    'type'        => 'varchar',//varchar, text, enum
                    'description' => 'Chave de acesso ao olark',
                ),

            )
        ),

        'api/facebook' => array(
            'title'        => 'Opções do Facebook',
            'descricao'    => 'Configurações do Facebook',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/facebook',
            'visibilidade' => 'admin', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                'API_FACEBOOK_APPID' => array(
                    'name'  => 'API_FACEBOOK_APPID',
                    'label' => 'Id do aplicativo do Facebook',
                    'type'  => 'varchar',//varchar, text, enum
                ),

                'API_FACEBOOK_APPSECRET' => array(
                    'name'  => 'API_FACEBOOK_APPSECRET',
                    'label' => 'Chave secreta do aplicativo do Facebook',
                    'type'  => 'varchar',//varchar, text, enum
                ),

                'API_FACEBOOK_FANPAGE' => array(
                    'name'  => 'API_FACEBOOK_FANPAGE',
                    'label' => 'Link da fanpage do facebook',
                    'type'  => 'varchar',//varchar, text, enum
                ),
            )
        ),

        'api/yahoo' => array(
            'title'        => 'Yahoo API',
            'descricao'    => 'Configurações do Yahoo',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/yahoo',
            'visibilidade' => 'admin', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                'API_YAHOO_APPID' => array(
                    'name'  => 'API_YAHOO_APPID',
                    'label' => 'Id do aplicativo do Yahoo',
                    'type'  => 'varchar',//varchar, text, enum
                ),

                'API_YAHOO_APPSECRET' => array(
                    'name'  => 'API_YAHOO_APPSECRET',
                    'label' => 'Chave secreta do aplicativo do Yahoo',
                    'type'  => 'varchar',//varchar, text, enum
                )
            )
        ),

        'api/google' => array(
            'title'        => 'Google API',
            'descricao'    => 'Configurações do Google',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/google',
            'visibilidade' => 'admin', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                'API_GOOGLE_APPID' => array(
                    'name'  => 'API_GOOGLE_APPID',
                    'label' => 'Id do aplicativo do Google',
                    'type'  => 'varchar',//varchar, text, enum
                ),

                'API_GOOGLE_APPSECRET' => array(
                    'name'  => 'API_GOOGLE_APPSECRET',
                    'label' => 'Chave secreta do aplicativo do Google',
                    'type'  => 'varchar',//varchar, text, enum
                )
            )
        ),

        'api/twitter' => array(
            'title'        => 'Twitter API',
            'descricao'    => 'Configurações do Twitter',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/twitter',
            'visibilidade' => 'admin', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                'API_YAHOO_APPID' => array(
                    'name'  => 'API_TWITTER_APPID',
                    'label' => 'Id do aplicativo do Twitter',
                    'type'  => 'varchar',//varchar, text, enum
                ),

                'API_YAHOO_APPSECRET' => array(
                    'name'  => 'API_TWITTER_APPSECRET',
                    'label' => 'Chave secreta do aplicativo do Twitter',
                    'type'  => 'varchar',//varchar, text, enum
                )
            )
        ),

        'api/bitly' => array(
            'title'        => 'Bitly API',
            'descricao'    => 'Configurações do Bitly',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/bitly',
            'visibilidade' => 'admin', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                'API_BITLY_APPSECRET' => array(
                    'name'  => 'API_BITLY_APPSECRET',
                    'label' => 'Chave secreta do aplicativo do Bitly',
                    'type'  => 'varchar',//varchar, text, enum
                ),
                'API_BITLY_DOMAIN'    => array(
                    'name'          => 'API_BITLY_DOMAIN',
                    'label'         => 'Domínio da API do bitly',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => 'bit.ly',
                    'description'   => 'Dominio que sera inserido na URL encurtada',
                    'value'         => '',
                    'value_default' => ''
                ),
            )
        ),

        'api/live' => array(
            'title'        => 'Live API',
            'descricao'    => 'Configurações do Windows Live',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/live',
            'visibilidade' => 'admin', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                'API_LIVE_APPID' => array(
                    'name'  => 'API_LIVE_APPID',
                    'label' => 'Id do aplicativo do Windows Live',
                    'type'  => 'varchar',//varchar, text, enum
                ),

                'API_LIVE_APPSECRET' => array(
                    'name'  => 'API_LIVE_APPSECRET',
                    'label' => 'Chave secreta do aplicativo do Windows Live',
                    'type'  => 'varchar',//varchar, text, enum
                )
            )
        ),

        'api/yt' => array(
            'title'        => 'YouTube API',
            'descricao'    => 'Configurações do YouTube',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/yt',
            'visibilidade' => 'webmaster', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                'API_YT_ID' => array(
                    'name'          => 'API_YT_ID',
                    'label'         => 'ID da API do youtube',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => "Acesse <a href=\"https://www.youtube.com/account_advanced\">https://www.youtube.com/account_advanced</a> para obter sua API ID",
                    'value'         => '',
                    'value_default' => ''
                ),

            )
        ),

        'api/lkd' => array(
            'title'        => 'Linkedin API',
            'descricao'    => 'Configurações do YouTube',
            'grupo'        => 'APIs Externas',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/lkd',
            'visibilidade' => 'webmaster', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                'API_LKD_ID' => array(
                    'name'          => 'API_LKD_ID',
                    'label'         => 'ID da API do Linkedin',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => "",
                    'value'         => '',
                    'value_default' => ''
                ),

            )
        ),

        'api/ga' => array(
            'title'        => 'Opções do Google Analytics',
            'descricao'    => 'Configurações do Google Analytics',
            'grupo'        => 'Web Analytics API',
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

        'api/luckorange' => array(
            'title'        => 'Opções do Luck Orange',
            'descricao'    => 'Configurações do Luck Orange',
            'grupo'        => 'Web Analytics API',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/luckorange',
            'visibilidade' => 'webmaster', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                'API_LUCK_ORANGE_KEY' => array(
                    'name'          => 'API_LUCK_ORANGE_KEY',
                    'label'         => 'Lucky Orange Identifier',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Chave de acesso ao lucky orange',
                    'value'         => '',
                    'value_default' => ''
                ),

            )
        ),

        'api/adwords' => array(
            'title'        => 'Google AdWords',
            'descricao'    => 'Configurações do Google AdWords',
            'grupo'        => 'Web Analytics API',
            'type'         => 'resource', //config, plugin, jsplugin, template, resource
            'referencia'   => 'api/adwords',
            'visibilidade' => 'webmaster', //'usuario', 'admin', 'webmaster'
            'configs'      => array(
                'API_ADWORDS_KEY' => array(
                    'name'          => 'API_ADWORDS_KEY',
                    'label'         => 'Adwords Identifier',
                    'type'          => 'varchar',//varchar, text, enum
                    'default'       => '',
                    'description'   => 'Chave de acesso ao google adwords',
                    'value'         => '',
                    'value_default' => ''
                ),

            )
        ),

    );
}
