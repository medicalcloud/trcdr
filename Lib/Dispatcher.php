<?php
Pathes::loadLib("Request");
class Dispatcher {
    
    private $modelName;
    private $request;
    
    public function __construct($modelName){
        $this->modelName = $modelName;
        $this->request = new Request();
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
        $this->dispatchIfRequestIs("GET", true, "ShowOne");
        $this->dispatchIfRequestIs("GET", false, "ShowMany");
        $this->dispatchIfRequestIs("POST", false, "Create");
        $this->dispatchIfRequestIs("PUT", true, "Update");
        $this->dispatchIfRequestIs("DELETE", true, "Remove");
        $this->redirectTo('index.php');
    }

    public function workAsGenericEdit(){
        $this->workAsGenericGetForMember('EditForm');
    }

    public function workAsGenericNew(){
        $this->workAsGenericGetForCollection('NewForm');
    }

    public function workAsGenericGetForMember($actionName){
        $this->dispatchIfRequestIs("GET", true, $actionName);
        $this->redirectTo('index.php');
    }

    public function workAsGenericGetForCollection($actionName){
        $this->dispatchIfRequestIs("GET", false, $actionName);
        $this->redirectTo('index.php');
    }

    public function dispatchIfRequestIs($method, $isForMember, $viewName){
        if($this->request->virtualMethod() === $method &&
           $this->request->isForMember() === $isForMember){
               $this->dispatchTo($viewName);
               die(); 
        }
    }    

    public function redirectIfRequestIs($method, $isForMember, $pathName){
        if($this->request->virtualMethod() === $method &&
           $this->request->isForMember() === $isForMember){
               $this->redirectTo($viewName);     
        }
    }    


    public function dispatchTo($viewName){
        Pathes::execApp($this->modelName, $viewName.'View');
    }

    public function redirectTo($pathName){
        header ('Location: '.Pathes::buildUrl($this->modelName.'/'.$pathName));
    }
}

