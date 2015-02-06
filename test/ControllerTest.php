<?php
Pathes::loadLib('Controller');
Pathes::loadLib('SharedObjects');

class ControllerTest extends PHPUnit_Framework_TestCase{
    public function setUp(){
        $this->controller = new Controller();
    }
    public function testModelClass(){
        $this->controller->setModelName("A");
        $this->assertEquals($this->controller->getModelName(), "A");
    }

   public function testCountPerPage(){
        $this->controller->setCountPerPage(9);
        $this->assertEquals($this->controller->getCountPerPage(), 9);
    }


}
