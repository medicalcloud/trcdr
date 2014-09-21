<?php
class Session {

    public function __construct(){
        $this->sessionStarted = false;
        $this->start();
        $this->sessionIdIsRegenerated = false;
    }

    public function start(){
        if(!$this->sessionStarted){
            session_start();
            $this->sessionStarted = true;
        }
    }

    public function stop(){
        if($this->sessionStarted){
            session_destroy();
            $this->sessionStarted = false;
        }
 
    }

    public function set($name, $value){
        $_SESSION[$name] = $value;
    }

    public function get($name){
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

    public function regenerate($destroy = true){
        if (!$this->sessionIdIsRegenerated) {
            session_regenerate_id($destroy);
            $this->sessionIdIsRegenerated = true;
        }
    }

    public function logInUser($user_id){
        $this->set('_authenticated_user_id', $user_id);
        $this->regenerate();
    }

    public function logOutUser(){
        $this->remove('_authenticatedUserId');
        $this->stop();
    }

    public function getUserId(){
        return $this->get('_authenticatedUserId');
    }

    public function isLogedIn(){
        return (null !== $this->get('_authenticatedUserId'));
    }

    public function logedInOrRedirectTo($modelName, $pathName){
        if(!($this->isLogedIn())){
            $this->set('_urlBeforeLogin', $_SERVER['REQUEST_URI']);
            $dispatcher = new Dispatcher($modelName);
            $dispatcher->redirectTo($pathName);
        }
    }

    public function redirectToUrlBeforeLogin(){
        $urlBeforeLogin = $this->get('_urlBeforeLogin');
        if(isset($urlBeforeLogin)){
            header ('Location: '.$urlBeforeLogin);
            die;
        }
    }

    public function getUrlBeforeLogin(){
        return $this->get('_urlBeforeLogin');
    }
}

