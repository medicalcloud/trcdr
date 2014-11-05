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

    private function __construct(){
        $this->params = array();
    }

    public static function instance(){
        global $SP;
            if(empty($SP)){
                $SP = new SharedParams();
            }
        return $SP;
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

