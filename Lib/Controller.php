<?php
Pathes::loadLib("Model");
Pathes::loadLib("Helpers");
Pathes::loadLib("SharedObjects");
class Controller {
    protected $modelName;
    protected $count_per_page = 12;

    public function __construct($modelName = ""){
        if($modelName !== ""){
            $this->dirname = lcfirst($modelName);
            $this->modelName = $modelName;
        }
    }

    public function setModelName($modelName){
        $this->modelName = $modelName;
    }

    public function getModelName(){
        return $this->modelName;
    }

    public function setCountPerPage($count_per_page){
        $this->count_per_page = $count_per_page;
    }

    public function getCountPerPage(){
        return $this->count_per_page;
    }

    protected function render($viewName){
        Pathes::execApp(lcfirst($this->modelName), $viewName."View");
    }
    
    public function showMany(){
        global $SO;
        $page = $SO->request()->params('page');
        if(empty($page)){
            $page = 1;
        }
        $modelclass = ucfirst($this->modelName).'Model';
        $SO->set('page', $page);
        $SO->set('items', $modelclass::findMany($page, $this->count_per_page));
        $this->render("ShowMany");
    }

    public function showOne(){
        global $SO;
        $id = $SO->request()->params('id');
        $modelclass = ucfirst($this->modelName).'Model';
        $item = $modelclass::findOne($id);
        if(empty($item)){
            $SO->redirect(lcfirst($this->modelName).'/index.php');
        }
        $SO->set('item', $item);
        $this->render('ShowOne');
    }

    public function newForm(){
        $this->render('NewForm');
    }

    public function editForm(){
        global $SO;
        $id = $SO->request()->params('id');
        $modelclass = ucfirst($this->modelName).'Model';
        $item = $modelclass::findOne($id);
        if(empty($item)){
            $SO->redirect(lcfirst($this->modelName).'/index.php');
        }
        $SO->set('item', $item);
        $this->render('EditForm');
    }

    public function create(){
        global $SO;
        $params = $SO->request()->params();

        $modelclass = ucfirst($this->modelName).'Model';
        $modelclass::create($params);
        global $SO;
        $SO->redirect(lcfirst($this->modelName).'/index.php');
    }

    public function update(){
        global $SO;
        $params = $SO->request()->params();
        $modelclass = ucfirst($this->modelName).'Model';
        $modelclass::update($params);
        $SO->redirect(lcfirst($this->modelName).'/index.php');
    }

    public function remove(){
        global $SO;
        $id = $SO->request()->params('id');
        $modelclass = ucfirst($this->modelName).'Model';
        $modelclass::remove($id);
        $SO->redirect(lcfirst($this->modelName).'/index.php');
    }
}

