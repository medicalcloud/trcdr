<?php
Pathes::loadApp("item","ItemController");
class ItemControllerTest extends PHPUnit_Framework_TestCase{
    public function setUp(){
    }

    public function testShowMany(){
        #ItemController::showMany();
    }

    public function testShowOne(){
        #ItemController::showOne();
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
