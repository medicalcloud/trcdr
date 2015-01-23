<?php
Pathes::loadLib("DBManager");

class Model {
    protected static $dbh;
    protected static $tableName = 'tablename';
    protected static $cachedStatements = array();
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

    public static function buildStt($SQL){
        if(isset(static::$cachedStatements[$SQL])) {
            return static::$cachedStatements[$SQL];
        } else {
            $dbh = static::getDbh();
            static::$cachedStatements[$SQL] = $dbh->prepare($SQL);
            return static::$cachedStatements[$SQL];
        }
    }

    public static function findAll($where = ''){
        $SQL = 'SELECT * FROM '.static::$tableName;
        if($where != ''){
            $SQL = $SQL.' WHERE '.$where;
        }
        $stt = static::buildStt($SQL);
        $stt->execute();
        return $stt->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }

    public static function findMany($page, $count_per_page, $where = ''){
        $from = ($page - 1) * $count_per_page;
        $SQL = 'SELECT * FROM '.static::$tableName.' LIMIT '.$from.', '.$count_per_page;
        if($where != ''){
            $SQL = $SQL.' WHERE '.$where;
        }
        $stt = static::buildStt($SQL);
        $stt->execute();
        return $stt->fetchAll(PDO::FETCH_CLASS, get_called_class());
    }

    public static function findOne($id){
        $SQL = 'SELECT * FROM '.static::$tableName.' WHERE id = :id';
        $stt = static::buildStt($SQL);
        $stt->bindValue(':id', $id);
        $stt->execute();
        return $stt->fetchObject(get_called_class());
    }

    public static function findOneByParam($name, $value){
        $SQL = 'SELECT * FROM '.static::$tableName.' WHERE '.$name.' = :value';
        $stt = static::buildStt($SQL);
        $stt->bindValue(':value', $value);
        $stt->execute();
        return $stt->fetchObject(get_called_class());
    }

    public static function create($params){
        $cn_csv = implode(', ', static::columnNames($params));
        $placeholders = array_map(
             function($s){return ':'.$s;},
             static::columnNames($params));
        $ph_csv = implode(', ', $placeholders);
        $SQL = 'INSERT INTO '.static::$tableName.' ('.$cn_csv.', created, updated) VALUES ('.$ph_csv.', now(), now())';
 
        $stt = static::buildStt($SQL);
        $stt = static::bindParams($stt, static::columnNames($params), $params);
        $stt->execute();
        return null;
    }

    public static function update($params){
        $value_equal_placeholder_list = array_map(
             function($s){return $s.' = :'.$s;},
             static::columnNames($params));
        $piece = implode(', ', $value_equal_placeholder_list);
        $SQL = 'UPDATE '.static::$tableName.' SET '.$piece.', updated = now() WHERE id=:id';
        
        $stt = static::buildStt($SQL);
        $stt = static::bindParams($stt, static::columnNames($params), $params);
        $stt->bindValue(':id', $params['id']);
        $stt->execute();
        return $params['id'];
    }

    protected static function bindParams($stt, $columns, $params) {
        foreach($columns as $column) {
            if(isset($params[$column])) {
                $stt->bindValue(':'.$column, $params[$column]);
            }else{
                # error occured.
                die();
            }
        }
        return $stt;
    }

    protected static function columnNames($params){
        return array_intersect(static::$columnNames, array_keys($params));
    }

    public static function remove($id){
        $SQL = 'DELETE FROM '.static::$tableName.' WHERE id = :id';
        $stt = static::buildStt($SQL);
        $stt->bindValue(':id', $id);
        $stt->execute();
        return $id;
    }

    public static function changeTo($id, $column, $value){
        $SQL = 'UPDATE '.static::$tableName.' SET '.$column.'=:placeholder WHERE id=:id';
        $stt = static::buildStt($SQL);
        $stt->bindValue(':placeholder', $value);
        $stt->bindValue(':id', $id);
        $stt->execute();
        return $id;
    }

}

