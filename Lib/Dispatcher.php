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

    public static function instance($modelName){
        return new Dispatcher($modelName);
    }

    public function modelName(){
        return $this->modelName;
    }
    public function getModelName(){ return $this->modelName(); }

    public function setModelName($modelName){
        $this->modelName = $modelName;
    }

    public function dispatchAsGenericIndex(){
        if($this->requestIs("GET", "Member")){ $this->dispatch("showOne"); }
        else if($this->requestIs("GET", "Collection")){ $this->dispatch("showMany"); }
        else if($this->requestIs("POST", "Collection")){ $this->dispatch("create"); }
        else if($this->requestIs("PUT", "Member")){ $this->dispatch("update"); }
        else if($this->requestIs("DELETE", "Member")){ $this->dispatch("remove"); }
        else{ $this->redirect($this->modelName.'/'.'index.php');}
    }

    public function dispatchAsGenericEdit(){
        $this->dispatchAsGenericGetForMember('editForm');
    }

    public function dispatchAsGenericNew(){
        $this->dispatchAsGenericGetForCollection('newForm');
    }

    public function dispatchAsGenericGetForMember($actionName){
        if($this->requestIs("GET", "Member")){ $this->dispatch($actionName);}
        else{ $this->redirect($this->modelName.'/'.'index.php');}
    }

    public function dispatchAsGenericGetForCollection($actionName){
        if($this->requestIs("GET", "Collection")){ $this->dispatch($actionName);}
        else{ $this->redirect($this->modelName.'/'.'index.php');}
    }

    public function dispatchIfRequestIs($method, $target, $actionName){
        if($this->requestIs($method, $target)){
               $this->dispatch($actionName);
        }
    }

    public function requestIs($method, $target){
        global $SO;
        return ($SO->request()->getVirtualMethod() === $method &&
                $SO->request()->getTarget() === $target);
    }

    public function dispatch($actionName){
        $controllerFileName = ucfirst($this->modelName).'Controller';
        $controllerClassName = '\trcdr\\'.$controllerFileName;
        Pathes::loadApp($this->modelName, $controllerFileName);
        $controller = new $controllerClassName();
        $controller->$actionName();
    }

    public function redirect($path){
        global $SO;
        $SO->redirect($path);
    }
}

