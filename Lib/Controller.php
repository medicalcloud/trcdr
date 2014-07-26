<?php
Pathes::loadLib("Model");
Pathes::loadLib("Helpers");
class Controller {
    protected static $modelclass = "Model.php";
    public static function showMany(){
        $modelclass = static::$modelclass;
        return $modelclass::findMany();
    }

    public static function showOne($id){
        $modelclass = static::$modelclass;
        return $modelclass::findOne($id);
    }

    public static function newForm(){
        $modelclass = static::$modelclass;
        # do nothing
    }

    public static function editForm($id){
        $modelclass = static::$modelclass;
        return $modelclass::findOne($id);
    }

    public static function create($params){
        $modelclass = static::$modelclass;
        $modelclass::create($params);
        $dispatcher = new Dispatcher('item');
        $dispatcher->redirectTo("index.php");
    }

    public static function update($params){
        $modelclass = static::$modelclass;
        $modelclass::update($params);
        $dispatcher = new Dispatcher("item");
        $dispatcher->redirectTo("index.php");
    }

    public static function remove($id){
        $modelclass = static::$modelclass;
        $modelclass::remove($id);
        $dispatcher = new Dispatcher("item");
        $dispatcher->redirectTo("index.php");
    }
}

