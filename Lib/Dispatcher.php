<?php
Pathes::loadLib("Request");
Pathes::loadLib('SharedParams');
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
        $this->dispatchIfRequestIs("GET", "Member", "showOne");
        $this->dispatchIfRequestIs("GET", "Collection", "showMany");
        $this->dispatchIfRequestIs("POST", "Collection", "create");
        $this->dispatchIfRequestIs("PUT", "Member", "update");
        $this->dispatchIfRequestIs("DELETE", "Member", "remove");
        Pathes::redirectTo($this->modelName.'/'.'index.php');
    }

    public function workAsGenericEdit(){
        $this->workAsGenericGetForMember('editForm');
    }

    public function workAsGenericNew(){
        $this->workAsGenericGetForCollection('newForm');
    }

    public function workAsGenericGetForMember($actionName){
        $this->dispatchIfRequestIs("GET", "Member", $actionName);
        Pathes::redirectTo($this->modelName.'/'.'index.php');
    }

    public function workAsGenericGetForCollection($actionName){
        $this->dispatchIfRequestIs("GET", "Collection", $actionName);
        Pathes::redirectTo($this->modelName.'/'.'index.php');
    }

    public function dispatchIfRequestIs($method, $target, $actionName){
        if($this->request->getVirtualMethod() === $method &&
           $this->request->getTarget() === $target){
               $this->dispatchTo($actionName);
        }
    }    

    public function redirectIfRequestIs($method, $target, $pathName){
        if($this->request->getVirtualMethod() === $method &&
           $this->request->getTarget() === $target){
               Pathes::redirectTo($this->modelName.'/'.$pathName);
        }
    }


    public function dispatchTo($actionName){
        global $SP;
        $SP = SharedParams::instance();
        $controllerClassName = ucfirst($this->modelName).'Controller';
        Pathes::loadApp($this->modelName, $controllerClassName);
        $controller = new $controllerClassName();
        $controller->$actionName();
        die();
    }
}

