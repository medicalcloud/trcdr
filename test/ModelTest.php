<?php
require_once(_TR_LIBPATH."Model.php");

class ModelTest extends PHPUnit_Framework_TestCase{
    private $model;
    public function setUp(){
        $this->model = new Model();
    }

    public function testGetDbh(){
        $this->model->getDbh();
    }
}
