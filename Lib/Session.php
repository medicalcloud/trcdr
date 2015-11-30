<?php namespace trcdr;
class Session implements \ArrayAccess{

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

    public function set($key, $value){
        $_SESSION[$key] = $value;
        return $this;
    }

    public function get($key){
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }

    public function remove($key){
        unset($_SESSION[$key]);
    }

    public function clear(){
        $_SESSION = array();
    }

    // Method for ArrayAccess
    //
    public function toArray(){
        return $_SESSION;
    }

    public function offsetExists($offset){
        return isset($_SESSION[$offset]);
    }

    public function offsetGet($offset){
        return $this->get($offset);
    }

    public function offsetSet($offset, $value){
        $this->set($offset, $value);
    }

    public function offsetUnset($offset){
        $this->remove($offset);
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

    public function isNotLogedIn(){
        return !($this->isLogedIn());
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
    public function getUrlBeforeLogin(){ return $this->urlBeforeLogin(); }

    public function removeUrlBeforeLogin(){
        $this->remove('_urlBeforeLogin');
    }
}

