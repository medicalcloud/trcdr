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

    public static function redirectToOauthPage($redirect_uri, $scope = 'public_profile'){
        //redirect to FB and return to redirect_uri with code
        global $SO;
        $SO->session()->set('state', sha1(uniqid(mt_rand(), true)));
        $params = array(
            'client_id' => static::getAppId(),
            'redirect_uri' => $redirect_uri,
            'state' => $SO->session()->get('state'),
            'scope' => $scope,
        );
        $url = 'http://www.facebook.com/dialog/oauth?'.http_build_query($params);
        $SO->redirect($url);
        die();
    }

    public static function checkCSRF(){
        global $SO;
        if($SO->session()->get('state') != $_GET['state']){
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
            $body = static::fileGetContents($url);
            parse_str($body, $array);
            // access token is in $array['access_token']

            return $array['access_token'];
    }

    public static function getMe($access_token){
        $fields = "name,picture";
        $url = 'https://graph.facebook.com/me?access_token='.$access_token.'&fields='.$fields;
        $me = json_decode(static::fileGetContents($url));
        // fb user id: $me->id
        // fb user name: $me->name
        // fb icon: $me->picture->data->url
        return $me;
    }

    public static function getWork($access_token){
        $fields = "name,work";
        $url = 'https://graph.facebook.com/me?access_token='.$access_token.'&fields='.$fields;
        $me = json_decode(static::fileGetContents($url));
        return $me->work;
    }

    public static function getEducation($access_token){
        $fields = "name,education";
        $url = 'https://graph.facebook.com/me?access_token='.$access_token.'&fields='.$fields;
        $me = json_decode(static::fileGetContents($url));
        return $me->education;
    }

    public static function getFriends($access_token){
        $url = 'https://graph.facebook.com/me/friends?access_token='.$access_token;
        $friends = json_decode(static::fileGetContents($url));
        // $friends->data is array
        // friend id: data[n]->id
        // friend name: data[n]->name
        return $friends;
    }

    private static function fileGetContents($url){
        $context = stream_context_create(array(
            'http' => array('ignore_errors' => true)
        
        ));

        $file = file_get_contents($url, false, $context);
        
        preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $http_response_header[0], $matches);
        $status_code = $matches[1];

        if($status_code === '200'){
            return $file;
        }else{
            echo 'エラーが発生しました。('.$status_code.')';
            // あとで、きちんとビューにする。
            die();
        }
        // $proxy = array(
        //     'http' => array(
        //         'proxy' => 'http://pcproxy.itakura.toyo.ac.jp:8080/',
        //         'request_fulluri' => true,
        //     ),
        // );
        // $proxy_content = stream_context_create($proxy);
        // return file_get_contents($url, false, $proxy_content);
    }
}
