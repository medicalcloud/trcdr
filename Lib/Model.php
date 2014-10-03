<?php
Pathes::loadLib("DBManager");

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

    public static function findAll($where = ''){
        $SQL = 'SELECT * FROM '.static::$tableName;
        if($where != ''){
            $SQL = $SQL.' WHERE '.$where;
        }
        $stt = static::buildSttFromSql($SQL);
        $stt->execute();
        return $stt->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }

    public static function findMany($page, $count_per_page){
        $from = ($page - 1) * $count_per_page;
        $to = $page * $count_per_page;
        $SQL = 'SELECT * FROM '.static::$tableName.' LIMIT '.$from.', '.$to;
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

    public static function findOneByParam($name, $value){
        $SQL = 'SELECT * FROM '.static::$tableName.' WHERE '.$name.' = :value';
        $stt = static::buildSttFromSql($SQL);
        $stt->bindValue(':value', $value);
        $stt->execute();
        return $stt->fetchObject(get_called_class());
    }

    public static function create($params){
        $sttName = 'create_'.static::$tableName;
        $stt = static::buildSttFromFunction($sttName, static::buildSqlForCreate());
        $stt = static::bindParams($stt, static::createdColumnNames(), $params);
        $stt->execute();
        return null;
    }

    protected static function buildSqlForCreate() {
        $cn_csv = implode(', ', static::createdColumnNames());
        $placeholders = array_map(
             function($s){return ':'.$s;},
             static::createdColumnNames());
        $ph_csv = implode(', ', $placeholders);
        $SQL = 'INSERT INTO '.static::$tableName.' ('.$cn_csv.') VALUES ('.$ph_csv.')';
        return $SQL;
    }

    public static function update($params){
        $sttName = 'update_'.static::$tableName;
        $stt = static::buildSttFromFunction($sttName, static::buildSqlForUpdate());
        $stt = static::bindParams($stt, static::updatedColumnNames(), $params);
        $stt->bindValue(':id', $params['id']);
        $stt->execute();
        return $params['id'];
    }

    protected static function buildSqlForUpdate() {
        $value_equal_placeholder_list = array_map(
             function($s){return $s.' = :'.$s;},
             static::updatedColumnNames());
        $piece = implode(', ', $value_equal_placeholder_list);
        $SQL = 'UPDATE '.static::$tableName.' SET '.$piece.' WHERE id=:id';
        return $SQL;
    }

    protected static function bindParams($stt, $columns, $params) {
        foreach($columns as $column) {
            if(isset($params[$column])) {
                $stt->bindValue(':'.$column, $params[$column]);
            }else{
                echo $column.' should be included in $_REQUEST(in Model::bindParams)';
                die();
            }
        }
        return $stt;
    }

    protected static function updatedColumnNames(){
        if(isset(static::$updatedColumnNames)) {
            return static::$updatedColumnNames;
        }else{
            return static::$columnNames;
        }
    }

    protected static function createdColumnNames(){
        if(isset(static::$createdColumnNames)) {
            return static::$createdColumnNames;
        }else{
            return static::$columnNames;
        }
    }

    public static function remove($id){
        $SQL = 'DELETE FROM '.static::$tableName.' WHERE id = :id';
        $stt = static::buildSttFromSql($SQL);
        $stt->bindValue(':id', $id);
        $stt->execute();
        return $id;
    }

    public static function changeTo($id, $column, $value){
        $SQL = 'UPDATE '.static::tableName.' SET '.$column.'=:placeholder WHERE id=:id';
        $stt = static::buildSttFromSql($SQL);
        $stt->bindValue(':placeholder', $value);
        $stt->bindValue(':id', $id);
        $stt->execute();
        return $id;
    }

}

