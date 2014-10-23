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

}

