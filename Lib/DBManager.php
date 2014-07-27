<?php

class DBManager {
    protected static $dbh = [];
    protected static $DSN = "";
    protected static $username = "";
    protected static $password = "";


    public static function addDBParams($DSN, $username, $password){
        static::$DSN = $DSN;
        static::$username = $username;
        static::$password = $password;
    }

    public static function getDbh(){
        if(!(isset(self::$dbh[static::$DSN]))) {
            try {
                static::$dbh[static::$DSN] = new PDO(static::$DSN, static::$username, static::$password);
            } catch(PDOException $e) {
                die('Error:'.$e->getMessage());
            }
            return static::$dbh[static::$DSN];
        }
    }

    public function closeDbh($DSN = null){
        if($DSN === null) {
            static::$dbh = [];
        }else{
            unset(static::$dbh[$DSN]);
        }
    }
}
