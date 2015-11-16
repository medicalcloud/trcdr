<?php namespace trcdr;
class SharedObjects implements \ArrayAccess{
    //private $sess;
    //private $request;
    //private $mailer;
    private $params;
    //private $outerweb;

    #session method
    public function session(){
        if(!isset($this->params['session'])){
            Pathes::loadLib('Session');
            $this->params['session'] = new Session();
        }
        return $this->params['session'];
    }

    public function sessionStarted(){
        if(isset($this->params['session'])){
            return true;
        }else{
            return false;
        }
    }

    public function s(){
        return $this->session();
    }

    public function setSession($session){
        // this method is for test to set MockObject insted of Session
        $this->params['session'] = $session;
    }
    
    public function request(){
        if(!isset($this->params['request'])){
            Pathes::loadLib('Request');
            $this->params['request'] = new Request();
        }
        return $this->params['request'];
    }

    public function r(){
        return $this->request();
    }

    public function setRequest($request){
        // this method is for test to set MockObject insted of Request
        $this->params['request'] = $request;
    }

    public function mailer(){
        if(!isset($this->params['mailer'])){
            Pathes::loadLib('Mailer');
            $this->params['mailer'] = new Mailer();
        }
        return $this->params['mailer'];
    }

    public function outerWeb(){
        if(!isset($this->params['outerweb'])){
            Pathes::loadLib('OuterWeb');
            $this->params['outerweb'] = new OuterWeb();
        }
        return $this->params['outerweb'];
    }

    // wrapper for legacy
    public function servers(){ $this->outerWeb(); }

    public function mail($to, $title, $message, $from){
        return $this->mailer()->mail($to, $title, $message, $from);
    }

    private function __construct(){
        $this->params = array();
    }

    public static function instance(){
        global $SO;
            if(!isset($SO)){
                $SO = new SharedObjects();
            }
        return $SO;
    }

    public function set($key, $value){
        $this->params[$key] = $value;
    }

    public function get($key){
        if (isset($this->params[$key])) {
            return $this->params[$key];
        }elseif($key === 'session'){
            return $this->session();
        }elseif($key === 'request'){
            return $this->request();
        }elseif($key === 'outerweb'){
            return $this->outerweb();
        }elseif($key === 'mailer'){
            return $this->mailer();
        }else{
            return null;
        }
    }

    public function remove($key){
        unset($this->params[$key]);
    }

    // Method for ArrayAccess
    public function toArray(){
        return $this->params;
    }

    public function offsetExists($offset){
        return isset($this->params[$offset]);
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

    public function URLManager(){
        if(!isset($this->params['URLManager'])){
            Pathes::loadLib('URLManager');
            $this->params['URLManager'] = new URLManager();
        }
        return $this->params['URLManager'];
    }

    public function setURLManager($URLManager){
        $this->params['URLManager'] = $URLManager;
    }


    public function redirect($path){
        $this->URLManager()->redirect($path);
    }
}

