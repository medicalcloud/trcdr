<?php
class WebTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp(){
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://127.0.0.1/trcdr/');
    }

    public function testIndex(){
        $this->url('http://127.0.0.1/trcdr/item/');
        $this->assertEquals('Item List', $this->title());
    }

    public function testShow(){
        $this->url('http://127.0.0.1/trcdr/item/index.php?id=2');
        $this->assertEquals('Show Item 2', $this->title());
    }

    public function testNewAndCreate(){
        $this->url('http://127.0.0.1/trcdr/item/new.php');
        $this->assertEquals('New Item', $this->title());
    }

    public function testEditAndUpdate(){
        $this->url('http://127.0.0.1/trcdr/item/edit.php?id=3');
        $this->assertEquals('Edit Item 3', $this->title());
    }

    public function testDeleteItemFromList(){
        $this->url('http://127.0.0.1/trcdr/item');
        #$this->assertEquals('Example WWW Page', $this->title());
    }
}
