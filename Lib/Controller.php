<?php
Pathes::loadLib("Model");
Pathes::loadLib("Helpers");
class Controller {
    protected static $modelclass = "Model";
    protected static $count_per_page = 10;
    protected static $dirname = "modeldir";
    
    public function __construct(){
    }

    public function showAll(){
        $modelclass = static::$modelclass;
        return $modelclass::findAll();
    }

    public function showMany(){
        if(isset($_REQUEST['page'])){
            $page = $_REQUEST['page'];
        } else {
            $page = 1;
        }
        $modelclass = static::$modelclass;
        return $modelclass::findMany($page, static::$count_per_page);
    }


    public function showOne($id){
        $modelclass = static::$modelclass;
        $object = $modelclass::findOne($id);
        if(empty($object)){
            $dispatcher = new Dispatcher(static::$dirname);
            $dispatcher->redirectTo('index.php');
        }
        return $object;
    }

    public function newForm(){
        # do nothing
    }

    public function editForm($id){
        $modelclass = static::$modelclass;
        $object = $modelclass::findOne($id);
        if(empty($object)){
            $dispatcher = new Dispatcher(static::$dirname);
            $dispatcher->redirectTo('index.php');
        }
        return $object;
    }

    public function create($params){
        $modelclass = static::$modelclass;
        $modelclass::create($params);
        $dispatcher = new Dispatcher(static::$dirname);
        $dispatcher->redirectTo("index.php");
    }

    public function update($params){
        $modelclass = static::$modelclass;
        $modelclass::update($params);
        $dispatcher = new Dispatcher(static::$dirname);
        $dispatcher->redirectTo("index.php");
    }

    public function remove($id){
        $modelclass = static::$modelclass;
        $modelclass::remove($id);
        $dispatcher = new Dispatcher(static::$dirname);
        $dispatcher->redirectTo("index.php");
    }
}

