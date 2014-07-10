<?php
require_once(_TR_LIBPATH."DBManager.php");

class Model {
    protected static $dbh;
    protected static $table_name = "tablename";
    protected static $statements = [];
    public static function setTableName($table_name){
        static::$table_name = $table_name;
    }
    
    public static function get_dbh(){
        #if this model data exist on default DB
        #use default database handler
        #if this model data exist on other DB
        #set configuration on Config.php(but not implemented yet)
        if(static::$dbh === null){
            static::$dbh = DBManager::get_dbh();
        }
        return static::$dbh;
    }

    public static function prepare_stt($SQL){
        if(!(isset(self::$statements[$SQL]))){
            static::$statements[$SQL] = static::get_dbh()->prepare($SQL);
        }
        return static::$statements[$SQL];
    }

    public static function find_many(){
        $SQL = 'SELECT * FROM '.static::$table_name;
        $stt = static::prepare_stt($SQL);
        $stt->execute();
        return $stt->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }

    public static function find_one($id){
        $SQL = 'SELECT * FROM '.static::$table_name.' WHERE id = :id';
        $stt = static::prepare_stt($SQL);
        $stt->bindValue(':id', $id);
        $stt->execute();
        return $stt->fetchObject(get_called_class());
    }

    public static function create(){
        $SQL = 'SELECT * FROM '.static::$table_name.' WHERE id = :id';
        $stt = static::prepare_stt($SQL);
        $stt->bindValue(':id', $id);
        $stt->execute();
        return $stt;
    }

    public static function update(){
        $SQL = 'SELECT * FROM '.static::$table_name.' WHERE id = :id';
        $stt = static::prepare_stt($SQL);
        $stt->bindValue(':id', $id);
        $stt->execute();
        return $stt;
    }

    public static function remove(){
        $SQL = 'SELECT * FROM '.static::$table_name.' WHERE id = :id';
        $stt = static::prepare_stt($SQL);
        $stt->bindValue(':id', $id);
        $stt->execute();
        return $stt;
    }
}


