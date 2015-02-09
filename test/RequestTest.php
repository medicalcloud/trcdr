<?php
Pathes::loadLib("Request");
class RequestTest extends PHPUnit_Framework_TestCase{
    private $request;
    public function setUp(){
        $this->request = new Request();
    }

    public function testForGet(){
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertTrue($this->request->isGet());
        $this->assertFalse($this->request->isPost());
        $this->assertEquals($this->request->getVirtualMethod(), 'GET');
    }

    public function testForPost(){
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertFalse($this->request->isGet());
        $this->assertTrue($this->request->isPost());
        $this->assertEquals($this->request->getVirtualMethod(), 'POST');
    }

    public function testForPut(){
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $this->assertFalse($this->request->isGet());
        $this->assertTrue($this->request->isPut());
        $this->assertEquals($this->request->getVirtualMethod(), 'PUT');
    }


    public function testForDelete(){
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $this->assertFalse($this->request->isGet());
        $this->assertTrue($this->request->isDelete());
        $this->assertEquals($this->request->getVirtualMethod(), 'DELETE');
    }


    public function testForVertualPut(){
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = "PUT";
        $this->assertFalse($this->request->isGet());
        $this->assertFalse($this->request->isPost());
        $this->assertTrue($this->request->isPut());
        $this->assertEquals($this->request->getVirtualMethod(), 'PUT');
    }

    public function testForVertualDelete(){
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = "DELETE";
        $this->assertFalse($this->request->isGet());
        $this->assertFalse($this->request->isPost());
        $this->assertTrue($this->request->isDelete());
        $this->assertEquals($this->request->getVirtualMethod(), 'DELETE');
    }

    public function testForMember(){
        $_REQUEST['id'] = '5';
        $this->assertTrue($this->request->targetIsMember());
        $this->assertFalse($this->request->targetIsCollection());
 
    }

    public function testForCollection(){
        $_REQUEST['id'] = null;
        $this->assertFalse($this->request->targetIsMember());
        $this->assertTrue($this->request->targetIsCollection());
    }

    public function testGetTarget(){
        $_REQUEST['id'] = null;
        $this->assertEquals($this->request->getTarget(), 'Collection');
        $_REQUEST['id'] = '1';
        $this->assertEquals($this->request->getTarget(), 'Member');

    }

}
