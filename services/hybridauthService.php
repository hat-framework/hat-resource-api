<?php

/**
 *
 * Arquivo de autenticação e retorno de informações de contatos de redes sociais,
 *
 * if:   verifica se solicitação é ajax e retorna informações de contatos de usuário logado inseridas na sessão;
 * else: realiza autenticação de usuário em rede social e insere seus contatos na sessão.
 *
 */

require_once $_SERVER['DOCUMENT_ROOT'] . "/init.php";
$obj = new \classes\Classes\Object();

if (isset($_GET['type']) && $_GET['type'] == 'ajax') {

    $obj->LoadModel('planejador/email', 'email');
    $obj->LoadModel('planejador/convite', 'convite');

    $contatos = classes\Classes\session::getVar('apiSocialLogin');

    classes\Classes\session::destroy('apiSocialLogin');
    echo $contatos;
    die();

} else {

    try {

        $provider = $_GET['provider'];

        if ($provider == 'Live') {
            require_once(BASE_DIR . "vendor/hatframework/hat-resource-api/lib/http.php");
            require_once(BASE_DIR . "vendor/hatframework/hat-resource-api/lib/oauth_client.php");

            $client = new oauth_client_class;
            $client->server = 'Microsoft';
            $client->redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . dirname(strtok($_SERVER['REQUEST_URI'], '?')) . '/hybridauthService.php';
            $client->client_id = '0000000048193F21';
            $application_line = __LINE__;
            $client->client_secret = '5GtYefqlNaZFKgwyiCAdv7Qyc5hfXDxm';
            $client->scope = 'wl.basic wl.emails wl.birthday';

            if (($success = $client->Initialize())) {
                if (($success = $client->Process())) {
                    if (strlen($client->authorization_error)) {
                        $client->error = $client->authorization_error;
                        $success = false;
                    } elseif (strlen($client->access_token)) {
                        $success = $client->CallAPI(
                            'https://apis.live.net/v5.0/me/contacts',
                            'GET', array(), array( 'FailOnAccessError' => true ), $contacts);
                    }
                }
                $success = $client->Finalize($success);
            }

            if ($success) {
                $contatos = array();
                print_r($contatos);
                foreach ($contacts->data as $item) {
                    $contatos[] = array(
                        "identifier"  => (property_exists($item, 'id')) ? $item->id : "",
                        "webSiteURL"  => "",
                        "profileURL"  => "",
                        "photoURL"    => "",
                        "displayName" => (property_exists($item, 'name')) ? $item->name : "",
                        "description" => "",
                        "email"       => (property_exists($item, 'email_hashes')) ? $item->email_hashes[0] : ""
                    );
                }

                $return = array(
                    "success"  => true,
                    "contacts" => $contatos
                );

                classes\Classes\session::setVar('apiSocialLogin', json_encode($return));

                // Fecha o popup que foi aberto
                echo "<script type='text/javascript'>";
                echo "window.close();";
                echo "</script>";
                die();
            }

        } else {

            $obj->LoadResource('api', 'api');
            require_once(BASE_DIR . "vendor/hybridauth-start/hybridauth-start/hybridauth/Hybrid/Auth.php");

            if (!defined('API_YAHOO_APPID')) define('API_YAHOO_APPID', true);
            if (!defined('API_YAHOO_APPSECRET')) define('API_YAHOO_APPSECRET', true);
            if (!defined('API_GOOGLE_APPID')) define('API_GOOGLE_APPID', true);
            if (!defined('API_GOOGLE_APPSECRET')) define('API_GOOGLE_APPSECRET', true);
            if (!defined('API_TWITTER_APPID')) define('API_TWITTER_APPID', true);
            if (!defined('API_TWITTER_APPSECRET')) define('API_TWITTER_APPSECRET', true);

            $config = array(
                "base_url"   => URL . "vendor/hybridauth-start/hybridauth-start/hybridauth/",
                "providers"  => array(
                    // openid providers
                    "OpenID" => array(
                        "enabled" => false
                    ),

                    // www.yahooapis.com/
                    "Yahoo"  => array(
                        "enabled" => true,
                        "keys"    => array(
                            "key"    => API_YAHOO_APPID,
                            "secret" => API_YAHOO_APPSECRET
                        ),
                    ),
                    "AOL"    => array(
                        "enabled" => false
                    ),

                    /**
                     * https://developers.google.com/google-apps/contacts/v3/
                     * https://developers.google.com/+/web/api/rest/latest/people/list
                     */
                    "Google" => array(
                        "enabled"         => true,
                        "keys"            => array(
                            "id"     => API_GOOGLE_APPID,
                            "secret" => API_GOOGLE_APPSECRET
                        ),
                        "scope"           => "https://www.googleapis.com/auth/userinfo.profile " . // optional
                            "https://www.googleapis.com/auth/userinfo.email " . // optional
                            "https://www.googleapis.com/auth/contacts.readonly " .  // optional
                            "https://www.googleapis.com/auth/plus.login", // optional
                        "access_type"     => "online",   // optional
                        "approval_prompt" => "auto",     // optional
                    ),

                    /**
                     *
                     *
                     * Invalid Scopes: offline_access, read_stream, publish_stream, read_friendlists.
                     * This message is only shown to developers. Users of your app will ignore these permissions if present.
                     * Please read the documentation for valid permissions at:
                     * https://developers.facebook.com/docs/facebook-login/permissions
                     *
                     * */

                    "Facebook" => array(
                        "enabled"        => false,
                        "keys"           => array( "id" => "", "secret" => "" ),
                        "scope"          => "email, user_about_me, user_birthday, user_hometown, user_website,
                                    read_custom_friendlists, user_friends", // optional
                        //"display" => "popup", // optional
                        "trustForwarded" => false
                    ),

                    // https://apps.twitter.com/
                    "Twitter"  => array(
                        "enabled"      => true,
                        "keys"         => array(
                            "key"    => API_TWITTER_APPID,
                            "secret" => API_TWITTER_APPSECRET
                        ),
                        "includeEmail" => false
                    ),

                    // windows live
                    "Live"     => array(
                        "enabled" => true,
                        "keys"    => array(
                            "id"     => "0000000048193F21",
                            "secret" => "5GtYefqlNaZFKgwyiCAdv7Qyc5hfXDxm"
                        )
                    ),

                    "LinkedIn"   => array(
                        "enabled" => false,
                        "keys"    => array( "key" => "", "secret" => "" )
                    ),
                    "Foursquare" => array(
                        "enabled" => false,
                        "keys"    => array( "id" => "", "secret" => "" )
                    ),
                ),
                // If you want to enable logging, set 'debug_mode' to true.
                // You can also set it to
                // - "error" To log only error messages. Useful in production
                // - "info" To log info and error messages (ignore debug messages)
                "debug_mode" => true,
                // Path to file writable by the web server. Required if 'debug_mode' is not false
                "debug_file" => "text.txt",
            );

            $hybridauth = new Hybrid_Auth($config);

            $authProvider = $hybridauth->authenticate($provider);

            if ($authProvider->isUserConnected()) {

                $user_profile = $authProvider->getUserProfile();
                $access_token = $authProvider->getAccessToken();

                if ($user_profile && isset($user_profile->identifier)) {

                    $return = array(
                        "success"  => true,
                        "user"     => array_merge(get_object_vars($user_profile), $access_token),
                        "contacts" => $authProvider->getUserContacts()
                    );

                    classes\Classes\session::setVar('apiSocialLogin', json_encode($return));

                    // Fecha o popup que foi aberto
                    echo "<script type='text/javascript'>";
                    echo "window.close();";
                    echo "</script>";
                    die();
                }
            }
        }

    } catch (Exception $e) {

        $code = $e->getCode();
        $message = "";

        switch ($e->getCode()) {
            case 0 :
                $message = "Unspecified error.";
                break;
            case 1 :
                $message = "Hybridauth configuration error.";
                break;
            case 2 :
                $message = "Provider not properly configured.";
                break;
            case 3 :
                $message = "Unknown or disabled provider.";
                break;
            case 4 :
                $message = "Missing provider application credentials.";
                break;
            case 5 :
                $message = "Authentication failed. "
                    . "The user has canceled the authentication or the provider refused the connection.";
                break;
            case 6 :
                $message = "User profile request failed. Most likely the user is not connected "
                    . "to the provider and he should to authenticate again.";
                $authProvider->logout();
                break;
            case 7 :
                $message = "User not connected to the provider.";
                $authProvider->logout();
                break;
            case 8 :
                $message = "Provider does not support this feature.";
                break;
        }

        classes\Classes\session::setVar('apiSocialLogin', json_encode(array(
            "success"         => false,
            "code"            => $code,
            "message"         => $message,
            "messageOriginal" => $e->getMessage(),
            "trace"           => $e->getTraceAsString()
        )));

        echo "<script type='text/javascript'>";
        echo "window.close();";
        echo "</script>";
        die();
    }
}
