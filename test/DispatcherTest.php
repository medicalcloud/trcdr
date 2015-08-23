<?php namespace trcdr;
Pathes::loadLib("Dispatcher");
class DispatcherTest extends \PHPUnit_Framework_TestCase{
    private $dispatcher;
    
    public function setUp(){
        $this->dispatcher = new Dispatcher("item");
    }
    
    public function testModelName(){
        $this->dispatcher->setModelName("foo");
        $this->assertEquals("foo", $this->dispatcher->getModelName());
    }
}
