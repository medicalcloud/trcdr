<?php namespace trcdr;
Pathes::loadLib("Request");
Pathes::loadLib('SharedObjects');
class Dispatcher {
    
    private $modelName;
    private $request;
    
    public function __construct($modelName){
        $this->modelName = $modelName;
        global $SO;
        $SO = SharedObjects::instance();
    }

    public function modelName(){
        return $this->modelName;
    }
    public function getModelName(){ return $this->modelName(); }

    public function setModelName($modelName){
        $this->modelName = $modelName;
    }

    public function dispatchAsGenericIndex(){
        $this->dispatchIfRequestIs("GET", "Member", "showOne");
        $this->dispatchIfRequestIs("GET", "Collection", "showMany");
        $this->dispatchIfRequestIs("POST", "Collection", "create");
        $this->dispatchIfRequestIs("PUT", "Member", "update");
        $this->dispatchIfRequestIs("DELETE", "Member", "remove");
        $this->redirect($this->modelName.'/'.'index.php');
    }

    public function dispatchAsGenericEdit(){
        $this->dispatchAsGenericGetForMember('editForm');
    }

    public function dispatchAsGenericNew(){
        $this->dispatchAsGenericGetForCollection('newForm');
    }

    public function dispatchAsGenericGetForMember($actionName){
        $this->dispatchIfRequestIs("GET", "Member", $actionName);
        $this->redirect($this->modelName.'/'.'index.php');
    }

    public function dispatchAsGenericGetForCollection($actionName){
        $this->dispatchIfRequestIs("GET", "Collection", $actionName);
        $this->redirect($this->modelName.'/'.'index.php');
    }

    public function dispatchIfRequestIs($method, $target, $actionName){
        global $SO;
        if($SO->request()->getVirtualMethod() === $method &&
           $SO->request()->getTarget() === $target){
               $this->dispatch($actionName);
        }
    }    

    public function dispatch($actionName){
        $controllerFileName = ucfirst($this->modelName).'Controller';
        $controllerClassName = '\trcdr\\'.$controllerFileName;
        Pathes::loadApp($this->modelName, $controllerFileName);
        $controller = new $controllerClassName();
        $controller->$actionName();
        die();
    }

    public function redirect($path){
        global $SO;
        $SO->redirect($path);
    }
}

