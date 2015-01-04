<?php

class FBManager {
    private static $fbAppName = '';
    private static $fbAppId = '';
    private static $fbAppSecret = '';

    public static function getAppName(){
        return self::$fbAppName;
    }

    public static function setAppName($fbAppName){
        self::$fbAppName = $fbAppName;
    }

    public static function getAppId(){
        return self::$fbAppId;
    }

    public static function setAppId($fbAppId){
        self::$fbAppId = $fbAppId;
    }

    public static function getAppSecret(){
        return self::$fbAppSecret;
    }

    public static function setAppSecret($fbAppSecret){
        self::$fbAppSecret = $fbAppSecret;
    }

    public static function redirectToOauthPage($redirect_uri, $scope = 'user_website'){
        global $SP;
        $SP->session()->set('state', sha1(uniqid(mt_rand(), true)));
        $params = array(
            'client_id' => static::getAppId(),
            'redirect_uri' => $redirect_uri,
            'state' => $SP->session()->get('state'),
            'scope' => $scope,
        );
        $url = 'http://www.facebook.com/dialog/oauth?'.http_build_query($params);
        header('Location: '.$url);
        die();
    }

    public static function checkCSRF(){
        global $SP;
        if($SP->session()->get('state') != $_GET['state']){
            echo 'state error';
            die();
        }
    }

    public static function getAccessToken($code, $redirect_uri){
        $params = array(
            'client_id' => static::getAppId(),
            'client_secret' => static::getAppSecret(),
            'code' => $code,
            'redirect_uri' => $redirect_uri);
            $url = 'https://graph.facebook.com/oauth/access_token?'.http_build_query($params);
            $body = file_get_contents($url);
            parse_str($body, $array);
            // access token is in $access_token

            return $array['access_token'];
    }
}
