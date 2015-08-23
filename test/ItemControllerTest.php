<?php namespace trcdr;

Pathes::loadApp("item","ItemController");
Pathes::loadLib('SharedObjects');
class ItemControllerTest extends \PHPUnit_Framework_TestCase{
    public function setUp(){
        global $SO;
        $SO = SharedObjects::instance();
    }

    public function testShowMany(){
        //$controller = $this->getMockBuilder('ItemController')->getMock();
        //$controller->method('rendor')->willReturn('null');
        $controller = new ItemController();
        $this->expectOutputRegex('/Item List/');
        $controller->showMany();
        
    }

    public function testShowOne(){
        $controller = new ItemController();
        global $SO;
        $_REQUEST['id'] = '2';
        $this->expectOutputRegex('/Show Item/');
        $controller->showOne();
    }
 
    public function testNewForm(){
        $controller = new ItemController();
        $this->expectOutputRegex('/New Item/');
        $controller->newForm();
    }
  
    public function testEditForm(){
        $controller = new ItemController();
        $_REQUEST['id'] = '2';
        $this->expectOutputRegex('/Edit Item/');
        $controller->editForm();
    }
 
    public function create(){
        $controller = new ItemController();
        $controller->create();
    }

    public function update(){
        $controller = new ItemController();
        $controller->update();
        #ItemController::update();
    }

    public function remove(){
        $controller = new ItemController();
        $controller->remove();
       #ItemController::remove();
    }
}
