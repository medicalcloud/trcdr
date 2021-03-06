<?php namespace trcdr;
class Request {
    public function isGet() {
        return $this->getVirtualMethod() === 'GET';
    }

    public function isPost() {
        return $this->getVirtualMethod() === 'POST';
    }

    public function isPut() {
        return $this->getVirtualMethod() === 'PUT';
    }

    public function isDelete() {
        return $this->getVirtualMethod() === 'DELETE';
    }

    public function targetIsMember() {
        return isset($_REQUEST['id']);
    }
    

    public function targetIsCollection() {
        return !isset($_REQUEST['id']);
    }

    public function getTarget() {
        if(isset($_REQUEST['id'])){
            return "Member";
        } else {
            return "Collection";
        }
    }

    public function virtualMethod() {
        $request_method = strtoupper($_SERVER['REQUEST_METHOD']);
        if($request_method === 'POST') {
            if(isset($_POST['_method'])){
                return strtoupper($_POST['_method']);
            } else {
                return 'POST';
            }
        } else { 
            return $request_method;
        }
    }
    public function getVirtualMethod() { return $this->virtualMethod(); }

    public function params($name = null){
        if(isset($name)){
            if(isset($_REQUEST[$name])){
                return $_REQUEST[$name];
            }else{
                return null;
            }
        }else{
            return $_REQUEST;
        }
    }

    public function url(){
        return $_SERVER['REQUEST_URI'];
    }

    public function p($name = null){
        return $this->params($name);
    }

    public function redirect($path){
        global $SO;
        $SO->redirect($path);
    }
}


