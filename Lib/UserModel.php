<?php

Pathes::loadLib("Model");

class UserModel extends Model {
    public static function create($params){
        if(isset($params["password"])){
            $params["password"] = crypt($params["password"], 'stars');
        }
        parent::create($params);
    }

    public static function update($params){
        if(isset($params["password"])){
            $params["password"] = crypt($params["password"], 'stars');
        }
        parent::update($params);
    }

    public function checkPassword($password){
        return (crypt($password, 'stars') === $this->password);
        
    }

    public function checkUserData(){
        //Userに不十分なデータがないかチェックする。
        if(empty($this->formNeededToCorrectUserData())){
            return false;
        }else{
            return true;
        }
    }

    public function formNeededToCorrectUserData(){
        //Userに不十分なデータがないか、チェックする。
        //もし、ユーザーデータに不十分な点があれば、
        //それを入力するために必要なフォームのURLを送る。
        //異常がなければ、nullを返す
        return '';
    }

}

