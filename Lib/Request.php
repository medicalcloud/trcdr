<?php
class Request {
    public function isGet() {
        return $this->methodCmp($_SERVER['REQUEST_METHOD'], 'GET');
    }

    public function isPost() {
        return $this->methodCmp($this->virtualMethod(), 'POST');
    }

    public function isPut() {
        return (($this->methodCmp($this->virtualMethod(), 'PUT')) ||
                 $this->methodCmp($_SERVER['REQUEST_METHOD'], 'PUT'));
    }

    public function isDelete() {
        return (($this->methodCmp($this->virtualMethod(), 'DELETE')) ||
               ($this->methodCmp($_SERVER['REQUEST_METHOD'], 'DELETE')));
    }

    public function isForMember() {
        return isset($_REQUEST['id']);
    }

    public function isForCollection() {
        return !(isset($_REQUEST['id']));
    }

    public function virtualMethod() {
        if($this->methodCmp($_SERVER['REQUEST_METHOD'], 'POST')) {
            if(isset($_POST['_method'])){
                return $_POST['_method'];
            } else {
                return 'POST';
            }
        } else { 
            return $_SERVER['REQUEST_METHOD'];
        }
    }

    private function methodCmp($str1, $str2){
        return strcasecmp($str1,$str2) === 0;
    }
}


