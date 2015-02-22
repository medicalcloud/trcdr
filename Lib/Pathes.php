<?php

class Pathes {
    private static $appPath = "";
    private static $libPath = "";
    private static $baseUrl = "";

    public static function getAppPath(){
        return self::$appPath;
    }

    public static function setAppPath($appPath){
        self::$appPath = $appPath;
    }

    public static function getLibPath(){
        return self::$libPath;
    }

    public static function setLibPath($libPath){
        self::$libPath = $libPath;
    }

    public static function getBaseUrl(){
        return self::$baseUrl;
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
}

