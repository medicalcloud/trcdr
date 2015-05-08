<?php
Pathes::loadLib('Model');
class FlagModel extends Model {
    // for baloon talking and bouncing user interface,
    // define flag in here
    // ui movement(talking or bouncing)is defined in view,
    // and in view check flag which defined in here,
    // and in view select which movement is shown.
    protected static $tableName = 'flag';
    protected static $columnNames = array('user_id', 'name');

    public static function doneFlags($user_id){
        // return done flags(object)
    }

    public static function yet($name, $user_id = null){
        if($user_id === null){
            $user_id = $SO->session()->user_id();
        }
        // return true, if name is not exist.
    }

    public static function already($name, $user_id = null){
        if($user_id === null){
            $user_id = $SO->session()->user_id();
        }
        // return true, if name is exist.
    }
    public static function undo(){
        // remove flag
    }
    public static function done(){
        // add flag
    }

}
