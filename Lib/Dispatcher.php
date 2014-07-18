<?php
require_once(_TR_LIBPATH."Request.php");
class Dispatcher {
    
    private $modelName;
    
    public function __construct($modelName){
        $this->modelName = $modelName;
    }

    public function getModelName(){
        return $this->modelName;
    }

    public function setModelName($modelName){
        $this->modelName = $modelName;
    }

    public function workAsGenericIndex(){
        $req = new Request();
        if ($req->isGet()) {
            if ($req->isForMember()) {
                $this->dispatchTo("show_one");
            } else {
                $this->dispatchTo("show_many");
            }
        } elseif($req->isPost()) {
            if ($req->isForCollection()) {
                $this->dispatchTo("create");
            } else {
                $this->redirectTo('index.php');
            }
        } elseif($req->isPut()) {
            if ($req->isForMember()) {
                $this->dispatchTo("update");
            } else {
                $this->redirectTo('index.php');
            }
        } elseif($req->isDelete()) {
            if ($req->isForMember()) {
                $this->dispatchTo("remove");
            } else {
                $this->redirectTo('index.php');
            }
        } else {
            $this->redirectTo('index.php');
        }
    }

    public function workAsGenericEdit(){
        $this->workAsGenericGetForMember('edit_form');
    }

    public function workAsGenericNew(){
        $this->workAsGenericGetForCollection('new_form');
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
        require(_TR_APPPATH.$this->modelName.'/'.$viewName.'_view.php');
    }

    public function redirectTo($pathName){
        header('Location: '._TR_BASEURL.$this->modelName.'/'.$pathName);
    }
}

