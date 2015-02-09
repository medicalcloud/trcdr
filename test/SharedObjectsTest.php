<?php
Pathes::loadLib("SharedObjects");
Pathes::loadLib("Request");
Pathes::loadLib("Session");
class SharedObjectsTest extends PHPUnit_Framework_TestCase{
    private $so;
    public function setup(){
        $this->so = SharedObjects::instance();
        $session = $this->getMockBuilder('Session')->getMock();
        $request = $this->getMockBuilder('Request')->getMock();
        $this->so->setSession($session);
        //$this->so->setRequest($request);
    }
    
    public function testSession(){
        $this->assertEquals($this->so->session(), 
            $this->so->s());
    }

    public function testRequest(){
        $this->assertEquals($this->so->request(), 
            $this->so->r());
    }
   
}
