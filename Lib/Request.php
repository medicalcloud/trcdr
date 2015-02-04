<?php
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

    public function getVirtualMethod() {
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

    public function params($name){
        if (empty($name)){
            return $_REQUEST;
        }else{
            return $_REQUEST[$name];
        }
    }

    public function redirect($path){
        if(preg_match('/^(https?|ftp):(:\/\/)/', $path)){
            header ('Location: '.$path);
        }else{
            header ('Location: '.Pathes::buildUrl($path));
        }
        die();
    }
}


