<?php

class FBManager {
    private static $fbAppName = '';
    private static $fbAppId = '';
    private static $fbAppSecret = '';

    public static function getFbAppName(){
        return self::$fbAppName;
    }

    public static function setFbAppName($fbAppName){
        self::$fbAppName = $fbAppName;
    }

    public static function getFbAppId(){
        return self::$fbAppId;
    }

    public static function setFbAppId($fbAppId){
        self::$fbAppId = $fbAppId;
    }

    public static function getFbAppSecret(){
        return self::$fbAppSecret;
    }

    public static function setFbAppSecret($fbAppSecret){
        self::$fbAppSecret = $fbAppSecret;
    }

    public static function redirectToOauthPage($redirect_uri, $scope = 'user_website, friend_website'){
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
            $url = 'http://www.facebook.com/oauth/access_token?'.http_build_query($params);
            parse_str(file_get_contents($url));
            // access token is in $access_token

            return $access_token;
    }
}
