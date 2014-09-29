<?php

Pathes::loadLib("Model");

class UserModel extends Model {
    public static function create($params){
        if(isset($params["password"])){
            $params["password"] = password_hash($params["password"], PASSWORD_DEFAULT);
        }
        parent::create($params);
    }

    public static function update($params){
        if(isset($params["password"])){
            $params["password"] = password_hash($params["password"], PASSWORD_DEFAULT);
        }
        parent::update($params);
    }

    public function checkPassword($password){
        return password_verify($password, $this->password);
        
    }

}

