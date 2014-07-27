<?php
class Request {
    public function isGet() {
        return $this->virtualMethod() === 'GET';
    }

    public function isPost() {
        return $this->virtualMethod() === 'POST';
    }

    public function isPut() {
        return $this->virtualMethod() === 'PUT';
    }

    public function isDelete() {
        return $this->virtualMethod() === 'DELETE';
    }

    public function isForMember() {
        return isset($_REQUEST['id']);
    }

    public function isForCollection() {
        return !(isset($_REQUEST['id']));
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
}


