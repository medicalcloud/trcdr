<?php
Pathes::loadLib("Model");
Pathes::loadLib("Helpers");
class Controller {
    protected static $modelclass = "Model.php";
    protected static $count_per_page = 10;
    protected static $dirname = "modeldir";

    public static function showAll(){
        $modelclass = static::$modelclass;
        return $modelclass::findAll();
    }

    public static function showMany(){
        if(isset($_REQUEST['page'])){
            $page = $_REQUEST['page'];
        } else {
            $page = 1;
        }
        $modelclass = static::$modelclass;
        return $modelclass::findMany($page, static::$count_per_page);
    }


    public static function showOne($id){
        $modelclass = static::$modelclass;
        return $modelclass::findOne($id);
    }

    public static function newForm(){
        # do nothing
    }

    public static function editForm($id){
        $modelclass = static::$modelclass;
        return $modelclass::findOne($id);
    }

    public static function create($params){
        $modelclass = static::$modelclass;
        $modelclass::create($params);
        $dispatcher = new Dispatcher(static::$dirname);
        $dispatcher->redirectTo("index.php");
    }

    public static function update($params){
        $modelclass = static::$modelclass;
        $modelclass::update($params);
        $dispatcher = new Dispatcher(static::$dirname);
        $dispatcher->redirectTo("index.php");
    }

    public static function remove($id){
        $modelclass = static::$modelclass;
        $modelclass::remove($id);
        $dispatcher = new Dispatcher(static::$dirname);
        $dispatcher->redirectTo("index.php");
    }
}

