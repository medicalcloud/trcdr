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

    public function dispatchAsGenericIndex(){
        $this->dispatchIfRequestIs("GET", "Member", "showOne");
        $this->dispatchIfRequestIs("GET", "Collection", "showMany");
        $this->dispatchIfRequestIs("POST", "Collection", "create");
        $this->dispatchIfRequestIs("PUT", "Member", "update");
        $this->dispatchIfRequestIs("DELETE", "Member", "remove");
        Pathes::redirect($this->modelName.'/'.'index.php');
    }

    public function dispatchAsGenericEdit(){
        $this->dispatchAsGenericGetForMember('editForm');
    }

    public function dispatchAsGenericNew(){
        $this->dispatchAsGenericGetForCollection('newForm');
    }

    public function dispatchAsGenericGetForMember($actionName){
        $this->dispatchIfRequestIs("GET", "Member", $actionName);
        Pathes::redirect($this->modelName.'/'.'index.php');
    }

    public function dispatchAsGenericGetForCollection($actionName){
        $this->dispatchIfRequestIs("GET", "Collection", $actionName);
        Pathes::redirect($this->modelName.'/'.'index.php');
    }

    public function dispatchIfRequestIs($method, $target, $actionName){
        if($this->request->getVirtualMethod() === $method &&
           $this->request->getTarget() === $target){
               $this->dispatch($actionName);
        }
    }    

//    public function redirectIfRequestIs($method, $target, $pathName){
//        if($this->request->getVirtualMethod() === $method &&
//           $this->request->getTarget() === $target){
//               Pathes::redirect(lcfirst($this->modelName).'/'.$pathName);
//        }
//    }


    public function dispatch($actionName){
        global $SP;
        $SP = SharedParams::instance();
        $controllerClassName = ucfirst($this->modelName).'Controller';
        Pathes::loadApp($this->modelName, $controllerClassName);
        $controller = new $controllerClassName();
        $controller->$actionName();
        die();
    }
}

