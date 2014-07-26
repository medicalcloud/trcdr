<?php
Pathes::loadLib("Model");

class ModelTest extends PHPUnit_Framework_TestCase{
    private $model;
    public function setUp(){
        $this->model = new Model();
    }

    public function testGetDbh(){
        $this->model->getDbh();
    }
}
