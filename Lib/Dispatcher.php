<?php
Pathes::loadLib("Request");
class Dispatcher {
    
    private $modelName;
    
    public function __construct($modelName){
        $this->modelName = $modelName;
    }

    public static function instance_for($modelName){
        return new Dispatcher($modelName);
    } 

    public function getModelName(){
        return $this->modelName;
    }

    public function setModelName($modelName){
        $this->modelName = $modelName;
    }

    public function workAsGenericIndex(){
        $req = new Request();
        $method = $req->virtualMethod();
        switch ($method){
            case "GET":
                if ($req->isForMember()) {
                    $this->dispatchTo("ShowOne");
                } else {
                    $this->dispatchTo("ShowMany");
                }
                break;
            case "POST":
                if ($req->isForCollection()) {
                    $this->dispatchTo("Create");
                } else {
                    $this->redirectTo('index.php');
                }
                break;
            case "PUT":
                if ($req->isForMember()) {
                    $this->dispatchTo("Update");
                } else {
                    $this->redirectTo('index.php');
                }
                break;
            case "DELETE":
                if ($req->isForMember()) {
                    $this->dispatchTo("Remove");
                } else {
                    $this->redirectTo('index.php');
                }
                break;
            default:
                $this->redirectTo('index.php');
                break;
        }
    }

    public function workAsGenericEdit(){
        $this->workAsGenericGetForMember('EditForm');
    }

    public function workAsGenericNew(){
        $this->workAsGenericGetForCollection('NewForm');
    }

    public function workAsGenericGetForMember($actionName){
        $req = new Request();
        if($req->isGet() && $req->isForMember()) {
            $this->dispatchTo($actionName);
        } else {
            $this->redirectTo('index.php');
        }
    }

    public function workAsGenericGetForCollection($actionName){
        $req = new Request();
        if($req->isGet() && $req->isForCollection()) {
            $this->dispatchTo($actionName);
        } else {
            $this->redirectTo('index.php');
        }
    }


    public function dispatchTo($viewName){
        Pathes::execApp($this->modelName, $viewName.'View');
    }

    public function redirectTo($pathName){
        header ('Location: '.Pathes::buildUrl($this->modelName.'/'.$pathName));
    }
}

