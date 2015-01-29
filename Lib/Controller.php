<?php
Pathes::loadLib("Model");
Pathes::loadLib("Helpers");
Pathes::loadLib("SharedParams");
class Controller {
    protected $modelName;
    protected $count_per_page = 12;
    private $sess;

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
        die();
    }

    public function showMany(){
        global $SP;
        if(isset($_REQUEST['page'])){
            $page = $_REQUEST['page'];
        } else {
            $page = 1;
        }
        $modelclass = ucfirst($this->modelName).'Model';
        $SP->set('page', $page);
        $SP->set('items', $modelclass::findMany($page, $this->count_per_page));
        $this->render("ShowMany");
    }

    public function showOne(){
        global $SP;
        $id = $_REQUEST['id'];
        $modelclass = ucfirst($this->modelName).'Model';
        $item = $modelclass::findOne($id);
        if(empty($item)){
            Pathes::redirect(lcfirst($this->modelName).'/index.php');
        }
        $SP->set('item', $item);
        $this->render('ShowOne');
    }

    public function newForm(){
        $this->render('NewForm');
    }

    public function editForm(){
        global $SP;
        $id = $_REQUEST['id'];
        $modelclass = ucfirst($this->modelName).'Model';
        $item = $modelclass::findOne($id);
        if(empty($item)){
            Pathes::redirect(lcfirst($this->modelName).'/index.php');
        }
        $SP->set('item', $item);
        $this->render('EditForm');
    }

    public function create(){
        $params = $_REQUEST;
        $modelclass = ucfirst($this->modelName).'Model';
        $modelclass::create($params);
        Pathes::redirect(lcfirst($this->modelName).'/index.php');
    }

    public function update(){
        $params = $_REQUEST;
        $modelclass = ucfirst($this->modelName).'Model';
        $modelclass::update($params);
        Pathes::redirect(lcfirst($this->modelName).'/index.php');
    }

    public function remove(){
        $id = $_REQUEST['id'];
        $modelclass = ucfirst($this->modelName).'Model';
        $modelclass::remove($id);
        Pathes::redirect(lcfirst($this->modelName).'/index.php');
    }
}

