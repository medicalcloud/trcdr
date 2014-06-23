<?php
class Request {
    public function isGet() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return true;
        } else {
            return false;
        }
    }

    public function isPost() {
        if ($this->virtualMethod() === 'POST') {
            return true;
        } else {
            return false;
        }
    }

    public function isPut() {
        if ($this->virtualMethod() === 'PUT') {
            return true;
        } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            return true;
        } else {
            return false;
        }
    }

    public function isDelete() {
        if ($this->virtualMethod() === 'DELETE') {
            return true;
        } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
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
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(isset($_POST['_method'])){
                return $_POST['_method'];
            } else {
                return 'POST';
            }
        } else { 
            return $_SERVER['REQUEST_METHOD'];
        }
    }
}


