<?php
require_once("../Lib/Request.php");
class Dispatcher {
    
    private $libpath;
    private $model_name;
    private $base_url;
    private $apppath;

    
    public function __construct($model_name, 
                                $base_url = '127.0.0.1/trcdr/',
                                $libpath = '../Lib/',
                                $apppath = '../App/'){
            
        $this->libpath = $libpath;
        $this->apppath = $apppath;
        $this->model_name = $model_name;
        $this->base_url = $base_url;
        require_once($this->libpath.'Request.php');
    }

    public function getLibPath(){
        return $this->libpath;
    }

    public function setLibPath($libpath){
        $this->libpath = $libpath;
    }

    public function getAppPath(){
        return $this->apppath;
    }

    public function setAppPath($apppath){
        $this->apppath = $apppath;
    }

    public function getModelName(){
        return $this->model_name;
    }

    public function setModelName($model_name){
        $this->model_name = $model_name;
    }

    public function getBaseUrl(){
        return $this->base_url;
    }

    public function setBaseUrl($base_url){
        $this->base_url = $base_url;
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
        require($this->apppath.$this->model_name.'/'.$view_name.'_view.php');
    }

    public function redirect_to($path_name){
        header('Location: '.$this->base_url.$this->model_name.'/'.$path_name);
    }
}

