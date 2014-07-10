<?php
class Request {
    public function isGet() {
        if ($this->methodComp($_SERVER['REQUEST_METHOD'], 'GET')) {
            return true;
        } else {
            return false;
        }
    }

    public function isPost() {
        if ($this->methodComp($this->virtualMethod(), 'POST')) {
            return true;
        } else {
            return false;
        }
    }

    public function isPut() {
        if ($this->methodComp($this->virtualMethod(), 'PUT')) {
            return true;
        } elseif ($this->methodComp($_SERVER['REQUEST_METHOD'], 'PUT')) {
            return true;
        } else {
            return false;
        }
    }

    public function isDelete() {
        if ($this->methodComp($this->virtualMethod(), 'DELETE')) {
            return true;
        } elseif ($this->methodComp($_SERVER['REQUEST_METHOD'], 'DELETE')) {
            return true;
        } else {
            return false;
        }
    }

    public function isForMember() {
        if (isset($_REQUEST['id'])) {
            return true;
        } else {
            return false;
        }
    }

    public function isForCollection() {
        if (!(isset($_REQUEST['id']))) {
            return true;
        } else {
            return false;
        }
    }

    public function virtualMethod() {
        if($this->methodComp($_SERVER['REQUEST_METHOD'], 'POST')) {
            if(isset($_POST['_method'])){
                return $_POST['_method'];
            } else {
                return 'POST';
            }
        } else { 
            return $_SERVER['REQUEST_METHOD'];
        }
    }

    function methodComp($str1, $str2){
        return strcasecmp($str1,$str2) === 0;
    }
}


