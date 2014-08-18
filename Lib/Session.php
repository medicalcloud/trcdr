<?php
class Session {

    public function __construct(){
        $this->start();
        $sessionIdIsRegenerated = false;
    }

    public function start(){
        if(!$sessionStarted){
            session_start();
            $sessionStarted = true;
        }
    }

    public function stop(){
        if($sessionStarted){
            session_destroy();
            $sessionStarted = false;
        }
 
    }

    public function get($name, $value){
        $_SESSION[$name] = $value;
    }

    public function set($name){
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    public function remove($name){
        unset($_SESSION[$name]);
    }

    public function clear(){
        $_SESSION = array();
    }

    public function regenerate($destory = true){
        if (!$sessionIdIsRegenerated) {
            session_regenerate_id($destroy);
            $sessionIdIsRegenerated = true;
        }
    }

    public function logInUser($user_id){
        $this->set('_authenticated_user_id', $user_id);
        $this->regenerate();
    }

    public function logOutUser(){
        $this->remove('_authenticated_user_id');
        $this->stop();
    }

    public function getUserId(){
        return $this->get('_authenticated_user_id');
    }

    public function isAuthenticated(){
        return $this->get('_authenticated_user_id');
    }
}

