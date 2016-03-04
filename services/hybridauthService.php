<?php

if (isset($_GET['provider'])) {

    require_once $_SERVER['DOCUMENT_ROOT'] . "/init.php";
    $obj = new \classes\Classes\Object();
    $obj->LoadResource('api', 'api');

    require_once(BASE_DIR . "vendor/hybridauth-start/hybridauth-start/Hybrid/Auth.php");

    if (!defined('API_YAHOO_APPID')) define('API_YAHOO_APPID', true);
    if (!defined('API_YAHOO_APPSECRET')) define('API_YAHOO_APPSECRET', true);
    if (!defined('API_GOOGLE_APPID')) define('API_GOOGLE_APPID', true);
    if (!defined('API_GOOGLE_APPSECRET')) define('API_GOOGLE_APPSECRET', true);
    if (!defined('API_TWITTER_APPID')) define('API_TWITTER_APPID', true);
    if (!defined('API_TWITTER_APPSECRET')) define('API_TWITTER_APPSECRET', true);

    $config = array(
        "base_url"   => URL . "vendor/hybridauth-start/hybridauth-start/",
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
                "enabled" => false,
                "keys"    => array(
                    "id"     => "",
                    "secret" => ""
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
        "debug_mode" => false,
        // Path to file writable by the web server. Required if 'debug_mode' is not false
        "debug_file" => "",
    );

    $provider = $_GET['provider'];

    try {

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

                die(json_encode($return));
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

        die(json_encode(array(
            "success"         => false,
            "code"            => $code,
            "message"         => $message,
            "messageOriginal" => $e->getMessage(),
            "trace"           => $e->getTraceAsString()
        )));
    }
} else {
    die(json_encode(array(
        "success" => false,
        "message" => "Nenhum parametro encontrado"
    )));
}
