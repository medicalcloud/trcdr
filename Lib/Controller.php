<?php
Pathes::loadLib("Model");
Pathes::loadLib("Helpers");
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

    public function session(){
        if(empty($this->sess)){
            $this->sess = new Session();
        }
        return $this->sess;
    }

    public function showAll(){
        $modelclass = $this->modelclass;
        return $modelclass::findAll();
    }

    public function showMany(){
        global $page;
        if(isset($_REQUEST['page'])){
            $page = $_REQUEST['page'];
        } else {
            $page = 1;
        }
        $modelclass = $this->modelclass;
        return $modelclass::findMany($page, $this->count_per_page);
    }

    public function showOne(){
        $id = $_REQUEST['id'];
        $modelclass = $this->modelclass;
        $object = $modelclass::findOne($id);
        if(empty($object)){
            $dispatcher = new Dispatcher($this->dirname);
            $dispatcher->redirectTo('index.php');
        }
        return $object;
    }

    public function newForm(){
        # do nothing
    }

    public function editForm(){
        $id = $_REQUEST['id'];
        $modelclass = $this->modelclass;
        $object = $modelclass::findOne($id);
        if(empty($object)){
            $dispatcher = new Dispatcher($this->dirname);
            $dispatcher->redirectTo('index.php');
        }
        return $object;
    }

    public function create(){
        $params = $_REQUEST;
        $modelclass = $this->modelclass;
        $modelclass::create($params);
        $dispatcher = new Dispatcher($this->dirname);
        $dispatcher->redirectTo("index.php");
    }

    public function update(){
        $params = $_REQUEST;
        $modelclass = $this->modelclass;
        $modelclass::update($params);
        $dispatcher = new Dispatcher($this->dirname);
        $dispatcher->redirectTo("index.php");
    }

    public function remove(){
        $id = $_REQUEST['id'];
        $modelclass = $this->modelclass;
        $modelclass::remove($id);
        $dispatcher = new Dispatcher($this->dirname);
        $dispatcher->redirectTo("index.php");
    }
}

