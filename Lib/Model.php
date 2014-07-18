<?php
require_once(_TR_LIBPATH."DBManager.php");

class Model {
    protected static $dbh;
    protected static $tableName = 'tablename';
    #protected static $columnNames = [];
    protected static $cachedStatements = [];
    public static function setTableName($tableName){
        static::$tableName = $tableName;
    }
    
    public static function getDbh(){
        #if this model data exist on default DB
        #use default database handler
        #if this model data exist on other DB
        #set configuration on Config.php(but not implemented yet)
        if(static::$dbh === null){
            static::$dbh = DBManager::getDbh();
        }
        return static::$dbh;
    }

    public static function buildSttFromSql($SQL){
        if(isset(static::$cachedStatements[$SQL])) {
            return static::$cachedStatements[$SQL];
        } else {
            $dbh = static::getDbh();
            static::$cachedStatements[$SQL] = $dbh->prepare($SQL);
            return static::$cachedStatements[$SQL];
        }
    }

    public static function buildSttFromFunction($sttName, $buildSqlFunc) {
        if(isset(static::$cachedStatements[$sttName])) {
            return static::$cachedStatements;
        } else {
            $dbh = static::getDbh();
            $SQL = $buildSqlFunc;
            static::$cachedStatements[$sttName] = $dbh->prepare($SQL);
            return static::$cachedStatements[$sttName];
        }
    }

    public static function findMany(){
        $SQL = 'SELECT * FROM '.static::$tableName;
        $stt = static::buildSttFromSql($SQL);
        $stt->execute();
        return $stt->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }

    public static function findOne($id){
        $SQL = 'SELECT * FROM '.static::$tableName.' WHERE id = :id';
        $stt = static::buildSttFromSql($SQL);
        $stt->bindValue(':id', $id);
        $stt->execute();
        return $stt->fetchObject(get_called_class());
    }

    public static function create($params){
        var_dump($_REQUEST);
        $sttName = 'create_'.static::$tableName;
        echo static::buildSqlForCreate();
        $stt = static::buildSttFromFunction($sttName, static::buildSqlForCreate());
        $stt = static::bindParams($stt, $params);
        $stt->execute();
        return null;
    }

    protected static function buildSqlForCreate() {
        $p1 = implode(' ', static::$columnNames);
        $placeholders = array_map(
             function($s){return ':'.$s;},
             static::$columnNames);
        $p2 = implode(' ', $placeholders);
        $SQL = 'INSERT INTO '.static::$tableName.' ('.$p1.') VALUES ('.$p2.')';
        return $SQL;
    }

    public static function update($params){
        $sttName = 'update_'.static::$tableName;
        $stt = static::buildSttFromFunction($sttName, static::buildSqlForUpdate());
        $stt = static::bindParams($stt, $params);
        $stt->bindValue(':id', $params['id']);
        $stt->debugDumpParams();
        $stt->execute();
        return null;
    }

    protected static function buildSqlForUpdate() {
        $value_equal_placeholder_list = array_map(
             function($s){return $s.' = :'.$s;},
             static::$columnNames);
        $piece = implode(', ', $value_equal_placeholder_list);
        $SQL = 'UPDATE '.static::$tableName.' SET '.$piece.' WHERE id=:id';
        return $SQL;
    }

    protected static function bindParams($stt, $params) {
        var_dump(static::$columnNames);
        foreach(static::$columnNames as $col) {
            if(isset($params[$col])) {
                echo "replace".':'.$col.' => '.$params[$col];
                $stt->bindValue(':'.$col, $params[$col]);
            }
        }
        return $stt;
    }

    public static function remove($id){
        $SQL = 'DELETE FROM '.static::$tableName.' WHERE id = :id';
        $stt = static::buildSttFromSql($SQL);
        $stt->bindValue(':id', $id);
        $stt->execute();
        return null;
    }
}

