<?php
Pathes::loadLib("Model");
Pathes::loadLib("Helpers");
Pathes::loadLib("SharedParams");
class Controller {
    protected $modelclass;
    protected $dirname;
    protected $count_per_page = 10;
    private $sess;

    public function __construct($modelclass = "", $dirname = ""){
        if($modelclass !== ""){
            $this->modelclass = $modelclass;
        }
        if($dirname !== ""){
            $this->dirname = $dirname;
        }
    }

    public function setModelClass($modelclass){
        $this->modelclass = $modelclass;
    }

    public function getModelClass(){
        return $this->modelclass;
    }

    public function setDirName($dirname){
        $this->dirname = $dirname;
    }

    public function getDirName(){
        return $this->dirname;
    }

    public function setCountPerPage($count_per_page){
        $this->count_per_page = $count_per_page;
    }

    public function getCountPerPage(){
        return $this->count_per_page;
    }

    private function render($viewName){
        Pathes::execApp($this->dirname, $viewName."View");
    }

    public function showAll(){
        $modelclass = $this->modelclass;
        return $modelclass::findAll();
    }

    public function showMany(){
        global $SP;
        $SP = new SharedParams();
        if(isset($_REQUEST['page'])){
            $page = $_REQUEST['page'];
        } else {
            $page = 1;
        }
        $modelclass = $this->modelclass;
        $SP->set('page', $page);
        $SP->set('items', $modelclass::findMany($page, $this->count_per_page));
        $this->render("ShowMany");
    }

    public function showOne(){
        global $SP;
        $SP = new SharedParams();
        $id = $_REQUEST['id'];
        $modelclass = $this->modelclass;
        $item = $modelclass::findOne($id);
        if(empty($item)){
            Pathes::redirectTo($this->dirname.'/index.php');
        }
        $SP->set('item', $item);
        $this->render('ShowOne');
    }

    public function newForm(){
        $this->render('NewForm');
    }

    public function editForm(){
        global $SP;
        $SP = new SharedParams();
        $id = $_REQUEST['id'];
        $modelclass = $this->modelclass;
        $item = $modelclass::findOne($id);
        if(empty($item)){
            Pathes::redirectTo($this->dirname.'/index.php');
        }
        $SP->set('item', $item);
        $this->render('EditForm');
    }

    public function create(){
        $params = $_REQUEST;
        $modelclass = $this->modelclass;
        $modelclass::create($params);
        Pathes::redirectTo($this->dirname.'/index.php');
    }

    public function update(){
        $params = $_REQUEST;
        $modelclass = $this->modelclass;
        $modelclass::update($params);
        Pathes::redirectTo($this->dirname.'/index.php');
    }

    public function remove(){
        $id = $_REQUEST['id'];
        $modelclass = $this->modelclass;
        $modelclass::remove($id);
        Pathes::redirectTo($this->dirname.'/index.php');
    }
}

