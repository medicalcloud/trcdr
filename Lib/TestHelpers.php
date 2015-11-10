<?php namespace trcdr;
class TestHelpers {
    protected static $basePath;
    public static function access($path) {
        require(static::$basePath.$path);
    }

    public static function setBasePath($basePath) {
        static::$basePath = $basePath;
        return $basePath;
    }

    public static function basePath(){
        return static::$basePath;
    }
}
