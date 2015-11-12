<?php namespace trcdr;
Pathes::loadLib("DBManager");

class Model {
    protected static $dbh;
    protected static $tableName = 'tablename';
    protected static $cachedStatements = array();

    public function __construct($params = null){
        if(isset($params)){
            foreach(static::columnName($params) as $columnName){
                $this[$column] = $params[$columnName];
            }
        }
    }

    public static function setTableName($tableName){
        static::$tableName = $tableName;
    }
    
    public static function dbh(){
        #if this model data exist on default DB
        #use default database handler
        #if this model data exist on other DB
        #set configuration on Config.php(but not implemented yet)
        if(static::$dbh === null){
            static::$dbh = DBManager::getDbh();
        }
        return static::$dbh;
    }
    public static function getDbh(){ return static::dbh(); }

    public static function buildStt($SQL){
        if(isset(static::$cachedStatements[$SQL])) {
            return static::$cachedStatements[$SQL];
        } else {
            $dbh = static::dbh();
            static::$cachedStatements[$SQL] = $dbh->prepare($SQL);
            return static::$cachedStatements[$SQL];
        }
    }

    public static function findAll($where = '', $option = ''){
        $SQL = 'SELECT * FROM '.static::$tableName;
        if($where != ''){
            $SQL = $SQL.' WHERE '.$where;
        }
        if($option != ''){
            $SQL = $SQL.' '.$option;
        }else{
            $SQL = $SQL.' ORDER BY created DESC';
        }
        $stt = static::buildStt($SQL);
        $stt->execute();
        return $stt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
    }

    public static function findMany($page, $count_per_page, $where = '', $option = ''){
        $from = ($page - 1) * $count_per_page;
        $SQL = 'SELECT * FROM '.static::$tableName;
        if($where != ''){
            $SQL = $SQL.' WHERE '.$where;
        }
        if($option != ''){
            $SQL = $SQL.' '.$option;
        }else{
            $SQL = $SQL.' ORDER BY created DESC';
        }
        $SQL = $SQL.' LIMIT '.$from.', '.$count_per_page;

        $stt = static::buildStt($SQL);
        $stt->execute();
        return $stt->fetchAll(\PDO::FETCH_CLASS, get_called_class());
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
        $SQL = 'INSERT INTO '.static::$tableName
            .' ('.$cn_csv.', created, updated) VALUES ('.$ph_csv.', now(), now())';
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
        $SQL = 'UPDATE '.static::$tableName
            .' SET '.$piece.', updated = now() WHERE id=:id';
        
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
                throw new TModelDataException('value of params['.$column.'] is null.');
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

    public static function putOutTrash($id){
        return static::trashFlag($id, '0');
    }

    public static function putInTrash($id){
        return static::trashFlag($id, '1');
    }

    public static function trashFlag($id, $flag = '1'){
        try{
            return static::update(array('id' =>$id, 'trash' => $flag));
        }catch(Exception $e){
            //do nothing
            //return static::remove($id);
        }
    }

    // Is changeOneColumn better name?
    public static function changeOneColumn($id, $column, $value){
        $SQL = 'UPDATE '.static::$tableName.' SET '.$column.'=:value WHERE id=:id';
        $stt = static::buildStt($SQL);
        $stt->bindValue(':value', $value);
        $stt->bindValue(':id', $id);
        $stt->execute();
        return $id;
    }

    //wrapper for regacy 
    public static function changeTo($id, $column, $value){
        return static::changeOneColumn($id, $column, $value);
    }
    
    public static function checkEmail($email){
        if(!(preg_match(
            '/^([a-z0-9_]|\-|\.|\+)+@(([a-z0-9_]|\-)+\.)+[a-z]{2,6}$/i',
            $email))) {
            throw new TModelDataException("wrong email address format");    
        }
        return $email;
    }

    public static function checkUrl($url){
        if(!(preg_match(
            '/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/',
            $url))){
            throw new TModelDataException("wrong url format");
        }
        return $url;
    }

    // varidation
    public static function checkOneLine($string){
        $string = str_replace('\0', '', $string);
        $string = preg_replace('/\s+/', ' ', $string);
        $string = mb_convert_kana($string, 'asKV', 'UTF-8');
        return $string;
    }

    public static function checkMultiLine($string){
        $string = str_replace('\0', '', $string);
        return $string;
    }

    public function toString(){
        return $this->__toString();
    }

    public function __toString(){
        return static::$tableName.'-'.$this->id;
    }
}

class TModelDataException extends \Exception{
}
