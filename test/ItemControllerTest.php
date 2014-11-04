<?php
Pathes::loadApp("item","ItemController");
class ItemControllerTest extends PHPUnit_Framework_TestCase{
    public function setUp(){
    }

    public function testShowMany(){
        #$controller = new ItemController();
        #$controller->showMany();
    }

    public function testShowOne(){
        #$controller = new ItemController();
        #$_REQUEST['id'] = '2';
        #$controller->showOne();
    }

    public function testNewForm(){
        #ItemController::newForm();
    }
    
    public function testEditForm(){
        #ItemController::editForm();
    }

    public function create(){
        #ItemController::create();
    }

    public function update(){
        #ItemController::update();
    }

    public function remove(){
        #ItemController::remove();
    }
}
