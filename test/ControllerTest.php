<?php
Pathes::loadLib('Controller');

class ControllerTest extends PHPUnit_Framework_TestCase{
    public function setUp(){
        $this->controller = new Controller();
    }
    public function testModelClass(){
        $this->controller->setModelClass("AModel");
        $this->assertEquals($this->controller->getModelClass(), "AModel");
    }
    public function testDirName(){
        $this->controller->setDirName("ADir");
        $this->assertEquals($this->controller->getDirName(), "ADir");
    }

   public function testCountPerPage(){
        $this->controller->setCountPerPage(9);
        $this->assertEquals($this->controller->getCountPerPage(), 9);
    }


}
