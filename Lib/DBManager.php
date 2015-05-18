<?php

class DBManager {
    protected static $dbh = array();
    protected static $DSN = "";
    protected static $username = "";
    protected static $password = "";


    public static function addDBParams($DSN, $username, $password){
        static::$DSN = $DSN;
        static::$username = $username;
        static::$password = $password;
    }

    public static function dbh(){
        if(!isset(static::$dbh[static::$DSN])) {
            try {
                static::$dbh[static::$DSN] = new PDO(static::$DSN, static::$username,
                    static::$password);
            } catch(PDOException $e) {
                die('Error:'.$e->getMessage());
            }
        }
        return static::$dbh[static::$DSN];
    }
    public static function getDbh(){ return static::dbh(); }

    public static function closeDbh($DSN = null){

        if($DSN === null) {
            static::$dbh = array();
        }else{
            unset(static::$dbh[$DSN]);
        }
    }
}
