<?php
require_once(_TR_LIBPATH."Request.php");
class RequestTest extends PHPUnit_Framework_TestCase{
    private $request;
    public function setUp(){
        $this->request = new Request();
    }

    public function testForGet(){
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $this->assertTrue($this->request->isGet());
        $this->assertFalse($this->request->isPost());
    }

    public function testForPost(){
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $this->assertFalse($this->request->isGet());
        $this->assertTrue($this->request->isPost());
    }

    public function testForPut(){
        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $this->assertFalse($this->request->isGet());
        $this->assertTrue($this->request->isPut());
    }


    public function testForDelete(){
        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $this->assertFalse($this->request->isGet());
        $this->assertTrue($this->request->isDelete());
    }


    public function testForVertualPut(){
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = "PUT";
        $this->assertFalse($this->request->isGet());
        $this->assertFalse($this->request->isPost());
        $this->assertTrue($this->request->isPut());
    }

    public function testForVertualDelete(){
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['_method'] = "DELETE";
        $this->assertFalse($this->request->isGet());
        $this->assertFalse($this->request->isPost());
        $this->assertTrue($this->request->isDelete());
    }

    public function testForMember(){
        $_REQUEST['id'] = '5';
        $this->assertTrue($this->request->isForMember());
        $this->assertFalse($this->request->isForCollection());
 
    }

    public function testForCollection(){
        $_REQUEST['id'] = null;
        $this->assertFalse($this->request->isForMember());
        $this->assertTrue($this->request->isForCollection());
    }
}
