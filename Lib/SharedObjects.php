<?php
class SharedObjects {
    private $sess;
    private $request;
    private $mailer;
    private $params;
    private $servers;

    #session method
    public function session(){
        if(!isset($this->sess)){
            Pathes::loadLib('Session');
            $this->sess = new Session();
        }
        return $this->sess;
    }

    public function s(){
        return $this->session();
    }

    public function setSession($session){
        // this method is for test to set MockObject insted of Session
        $this->sess = $session;
    }
    
    public function request(){
        if(!isset($this->request)){
            Pathes::loadLib('Request');
            $this->request = new Request();
        }
        return $this->request;
    }

    public function r(){
        return $this->request();
    }

    public function setRequest($request){
        // this method is for test to set MockObject insted of Request
        $this->request = $request;
    }

    public function mailer(){
        if(!isset($this->mailer)){
            Pathes::loadLib('Mailer');
            $this->mailer = new Mailer();
        }
        return $this->mailer;
    }

    public function servers(){
        if(!isset($this->servers)){
            Pathes::loadLib('Servers');
            $this->servers = new Servers();
        }
        return $this->servers;
    }

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

    public function set($name, $value){
        $this->params[$name] = $value;
    }

    public function get($name){
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }
        return null;
    }

    public function redirect($path){
        if(preg_match('/^(https?|ftp)(:\/\/)/', $path)){
            header ('Location: '.$path);
        }elseif(preg_match('/^\/trcdr/', $path)){  #start with /trcdr
            header ('Location: '.$path);
        }else{
            header ('Location: '.Pathes::buildUrl($path));
        }
        die();
    }
}

