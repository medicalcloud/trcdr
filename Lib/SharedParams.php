<?php
class SharedParams {
    private $sess;
    private $params;
    public function session(){
        if(empty($this->sess)){
            Pathes::loadLib('Session');
            $this->sess = new Session();
        }
        return $this->sess;
    }

    public function __construct(){
        $this->params = array();
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
}

