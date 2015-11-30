<?php namespace trcdr;
Pathes::loadLib('Model');
class FlagModel extends Model {
    // コード汚い。本当に必要？必要になったら、一旦、書き直し。
    // FlagModel->findByName()->yet()みたいな使い方がわかりやすいんじゃない？
    // for baloon talking and bouncing user interface,
    // define flag in here
    // ui movement(talking or bouncing)is defined in view,
    // and in view check flag which defined in here,
    // and in view select which movement is shown.
    protected static $tableName = 'flag';
    protected static $columnNames = array('user_id', 'name');

    public static function doneFlags($user_id = null){
        if(empty($user_id)){
            $user_id = $SO->session()->user_id();
        }
        $SQL = 'SELECT id, user_id, name FROM flag WHERE user_id = :user_id';
        $stt = static::buildStt($SQL);
        $stt->bindValue(':user_id', $user_id);
        $stt->execute();
        return $stt->fetchAll(PDO::FETCH_CLASS, 'FlagModel');
    }

    public static function yet($name, $user_id = null){
        if(empty($user_id)){
            $user_id = $SO->session()->user_id();
        }
        // return true, if name is not exist.
        $already = static::already($name, $user_id);
        return empty($already);
    }

    public static function already($name, $user_id = null){
        if(empty($user_id)){
            $user_id = $SO->session()->user_id();
        }
        // return true, if name is exist.
        $SQL = 'SELECT id FROM flag WHERE user_id = :user_id AND $name = :name';
        $stt = static::buildStt($SQL);
        $stt->bindValue(':name', $name);
        $stt->bindValue(':user_id', $user_id);
        $stt->execute();
        return $stt->fetchObject(get_called_class())->id;
        
    }
    public static function unfinish($name, $user_id){
        // remove flag
        $SQL = 'DELETE FROM flag WHERE name = :name AND user_id = :user_id';
        $stt->bindValue(':name', $name);
        $stt->bindValue(':user_id', $user_id);
        $stt->execute();
        return null;
    }

    public static function finish($name, $user_id){
        // add flag
        $SQL = 'INSERT INTO (name, user_id, created, updated) VALUES (:name, :user_id, now(), now())';
        $stt->bindValue(':name', $name);
        $stt->bindValue(':user_id', $user_id);
        $stt->execute();
        return null;
    }

}
