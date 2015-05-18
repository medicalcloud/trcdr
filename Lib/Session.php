<?php
class Session {

    public function __construct(){
        session_set_cookie_params(0, '/');
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

    public function logIn($user){
        $this->set('_authenticatedUserId', $user->id);
        $this->set('_authenticatedUserClassName', get_class($user));
        $this->regenerate();
    }

    public function logOut(){
        $this->remove('_authenticatedUserId');
        $this->remove('_authenticatedUserClassName');
        $this->stop();
    }

    public function userId(){
        $classname = $this->get('_authenticatedUserClassName');
        $user_id = $this->get('_authenticatedUserId');
        if($classname && $user_id){
            return $user_id;
        }else{
            return null;
        }
    }
    public function getUserId(){ return $this->userId(); }

    public function user(){
        $classname = $this->get('_authenticatedUserClassName');
        $user_id = $this->get('_authenticatedUserId');
        if($classname && $user_id){
            $user = $classname::findOne($user_id);
            if(!empty($user)){
                return $user;
            }
        }
        return null;
    }
    public function getUser(){ return $this->user(); }

    public function isLogedIn(){
        $classname = $this->get('_authenticatedUserId');
        $user_id = $this->get('_authenticatedUserClassName');
        if($classname && $user_id){
           return true;
        }else{
           return false;
        }
    }
   
    public function logedInOrRedirect($path){
        global $SO;
        if(!($this->isLogedIn())){
            $this->set('_urlBeforeLogin', $_SERVER['REQUEST_URI']);
            $SO->redirect($path);
        }
    }

    public function redirectToUrlBeforeLogin(){
        global $SO;
        $urlBeforeLogin = $this->get('_urlBeforeLogin');
        $this->removeUrlBeforeLogin();
        if(isset($urlBeforeLogin)){
            $SO->redirect($urlBeforeLogin);
        }
    }

    public function urlBeforeLogin(){
        $urlBeforeLogin = $this->get('_urlBeforeLogin');
        if(strpos($urlBeforeLogin, 'ajax')){
            return null;
        }else{
            return $urlBeforeLogin;
        }
    }
    public function getUrlBeforeLogin(){ return urlBeforeLogin(); }

    public function removeUrlBeforeLogin(){
        $this->remove('_urlBeforeLogin');
    }
}

