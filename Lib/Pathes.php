<?php namespace trcdr;

class Pathes {
    private static $appPath = "";
    private static $libPath = "";
    private static $baseUrl = "";

    public static function appPath(){
        return self::$appPath;
    }
    public static function getAppPath(){ return static::appPath(); }

    public static function setAppPath($appPath){
        self::$appPath = $appPath;
    }

    public static function libPath(){
        return self::$libPath;
    }
    public static function getLibPath(){ return static::libPath(); }

    public static function setLibPath($libPath){
        self::$libPath = $libPath;
    }

    public static function baseUrl(){
        return self::$baseUrl;
    }
    public static function getBaseUrl(){ return static::baseUrl(); }

    public static function basePath(){
        //self::baseUrl()には、'http://dev.trcdr.com/vac/'のような文字列が入っている。
        //ここから、vacのような文字列だけを抜き出す。
        $dirs = explode('/', self::baseUrl());
        while($dirs !== array()){
            $dir = array_pop($dirs);
            if($dir !== ""){
                return $dir;
            }
        }
        return "";
    }

    public static function setBaseUrl($baseUrl){
        self::$baseUrl = $baseUrl;
    }

    public static function loadLib($className){
        require_once(self::$libPath.$className.'.php');
    }

    public static function loadApp($modelName, $className){
        require_once(self::$appPath.$modelName.'/'.$className.'.php');
    }

    public static function execApp($modelName, $className){
        require(self::$appPath.$modelName.'/'.$className.'.php');
    }

    public static function renderPart($partname){ 
        #NOT RECOMMENDED
        #instead of this method,
        #use Helper#renderPart();
        Pathes::loadLib('Helper');
        renderPart($partname);
    }

    public static function buildUrl($path){
        return self::$baseUrl.$path;
    }

    public static function addAutoloadPath($libOrApp, $path){
        switch($libOrApp){
        case 'lib':
            spl_autoload_register(function($class){
                require(self::$libPath.$path.$class.'.php');
            });
            break;
        case 'app':
            spl_autoload_register(function($class){
                require(self::$appPath.$path.$class.'.php');
            });
            break;
        default:
            // do nothing
        }
    }
}

