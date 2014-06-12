<?php
class Model {
    private $db = null;
    private $DSN = 'mysql:host=localhost;dbname=trcdr;charset=utf8';
    private $username = 'root';
    private $passwd = 'isdcsbba';

    public function __construct($DSN, $username, $passwd){
        $this->DSN = $DSN;
        $this->username = $username;
        $this->passwd = $passwd;
    }

    public function find_all($model_name){
        #this method execute statement and return it
        $stt = prepareStt('SELECT * FROM :model_name');
        $stt->bindValue(':model_name', $model_name);
        $stt->execute;
        return $stt;
    }

    public function find($model_name, $id){
        $stt = prepareStt('SELECT * FROM :model_name WHERE id = :id');
        $stt->bindValue(':model_name', $model_name);
        $stt->bindValue(':id', $id);
        $stt->execute;
        return $stt;
    }

    public function create($model_name){
        $stt = prepareStt('');
        $stt->bindValue();
        $stt->execute;
        return $stt;
 
    }

    public function remove($model_name, $id){
        $stt = prepareStt('DELETE FROM :model_name WHERE id = :id');
        $stt->bindValue(':model_name', $model_name);
        $stt->bindValue(':id', $id);
        $stt->execute;
        return $stt;
    }

    public function update($model_name){
        $stt = prepareStt('');
        $stt->bindValue();
        $stt->execute;
        return $stt;
    }

    public function prepareStt(string $SQL){
        return getDb()->prepare($SQL);
    }

    public function getDb(){
        if($this->db === null) {
            try {
                $this->db = new PDO($this->DSN, $this->username, $this->passwd);
            } catch(PDOException $e) {
                die('Error:'.$e->getMessage());
            }
        }
    }
    public function closeDb(){
        $this->db = null;
    }
}
