<?php
Pathes::loadLib("Request");
class Dispatcher {
    
    private $modelName;
    private $request;
    
    public function __construct($modelName){
        $this->modelName = $modelName;
        $this->request = new Request();
    }

    public function getModelName(){
        return $this->modelName;
    }

    public function setModelName($modelName){
        $this->modelName = $modelName;
    }

    public function workAsGenericIndex(){
        $this->dispatchIfRequestIs("GET", "Member", "ShowOne");
        $this->dispatchIfRequestIs("GET", "Collection", "ShowMany");
        $this->dispatchIfRequestIs("POST", "Collection", "Create");
        $this->dispatchIfRequestIs("PUT", "Member", "Update");
        $this->dispatchIfRequestIs("DELETE", "Member", "Remove");
        $this->redirectTo('index.php');
    }

    public function workAsGenericEdit(){
        $this->workAsGenericGetForMember('EditForm');
    }

    public function workAsGenericNew(){
        $this->workAsGenericGetForCollection('NewForm');
    }

    public function workAsGenericGetForMember($actionName){
        $this->dispatchIfRequestIs("GET", "Member", $actionName);
        $this->redirectTo('index.php');
    }

    public function workAsGenericGetForCollection($actionName){
        $this->dispatchIfRequestIs("GET", "Collection", $actionName);
        $this->redirectTo('index.php');
    }

    public function dispatchIfRequestIs($method, $target, $viewName){
        if($this->request->getVirtualMethod() === $method &&
           $this->request->getTarget() === $target){
               $this->dispatchTo($viewName);
        }
    }    

    public function redirectIfRequestIs($method, $target, $pathName){
        if($this->request->getVirtualMethod() === $method &&
           $this->request->getTarget() === $target){
               $this->redirectTo($pathName);
        }
    }


    public function dispatchTo($viewName){
        Pathes::execApp($this->modelName, $viewName.'View');
        die();
    }

    public function redirectTo($pathName){
        header ('Location: '.Pathes::buildUrl($this->modelName.'/'.$pathName));
        die();
    }
}

