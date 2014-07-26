<?php
Pathes::loadApp("item","ItemController");
class ItemControllerTest extends PHPUnit_Framework_testCase{
    public function setUp(){
    }

    public function testShowMany(){
        ItemController::showMany();
    }

    public function testShowOne(){
        ItemController::showOne("1");
    }

    public function testNewForm(){
        ItemController::newForm();
    }
    
    public function testEditForm(){
        ItemController::editForm("2");
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
