<?php
require_once(_TR_LIBPATH."Request.php");
class Dispatcher {
    
    private $model_name;
    
    public function __construct($model_name){
            
        $this->model_name = $model_name;
    }

    public function getModelName(){
        return $this->model_name;
    }

    public function setModelName($model_name){
        $this->model_name = $model_name;
    }

    public function work_as_generic_index(){
        $req = new Request();
        if ($req->isGet()) {
            if ($req->isForMember()) {
                $this->dispatch_to("show");
            } else {
                $this->dispatch_to("list");
            }
        } elseif($req->isPost()) {
            if ($req->isForCollection()) {
                $this->dispatch_to("create");
            } else {
                $this->redirect_to('index.php');
            }
        } elseif($req->isPut()) {
            if ($req->isForMember()) {
                $this->dispatch_to("update");
            } else {
                redirect_to('index.php');
            }       
        } elseif($req->isDelete()) {
            if ($req->isForMember()) {
                $this->dispatch_to("delete");
            } else {
                $this->redirect_to('index.php');
            }
        } else {
            $this->redirect_to('index.php');
        }
    }

    public function work_as_generic_edit(){
        $this->work_as_generic_get_for_member('edit');
    }

    public function work_as_generic_new(){
        $this->work_as_generic_get_for_collection('new');
    }

    public function work_as_generic_get_for_member($action_name){
        $req = new Request();
        if($req->isGet() && $req->isForMember()) {
            $this->dispatch_to($action_name);
        } else {
            $this->redirect_to('index.php');
        }
    }

    public function work_as_generic_get_for_collection($action_name){
        $req = new Request();
        if($req->isGet() && $req->isForCollection()) {
            $this->dispatch_to($action_name);
        } else {
            $this->redirect_to('index.php');
        }
    }


    public function dispatch_to($view_name){
        require(_TR_APPPATH.$this->model_name.'/'.$view_name.'_view.php');
    }

    public function redirect_to($path_name){
        header('Location: '._TR_BASEURL.$this->model_name.'/'.$path_name);
    }
}

