<?php
class DBManager {
    protected static $dbh = [];

    public static function get_dbh($DSN = _TR_DSN,
                                   $username = _TR_DB_USERNAME,
                                   $password = _TR_DB_PASSWORD){
        if(!(isset(self::$dbh[$DSN]))) {
            try {
                self::$dbh[$DSN] = new PDO($DSN, $username, $password);
            } catch(PDOException $e) {
                die('Error:'.$e->getMessage());
            }
            return self::$dbh[$DSN];
        }
    }

    public function close_dbh($DSN){
        if($DSN === null) {
            self::$dbh = [];
        }else{
            unset(self::$dbh[$DSN]);
        }
    }
}
