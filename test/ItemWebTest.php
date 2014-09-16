<?php
class ItemWebTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp(){
        $this->setBrowser('phantomjs');
        $this->setBrowserUrl('http://127.0.0.1/trcdrlib/');
    }

    public function testIndex(){
        $this->url('http://127.0.0.1/trcdrlib/item/');
        $this->assertEquals('Item List', $this->title());
        #$this->byId('link_to_show_4')->click();
        #$this->byId('link_to_show_many')->click();
    }

    public function testShow(){
        #$this->url('http://127.0.0.1/trcdrlib/item/index.php?id=2');
        #$this->assertEquals('Show Item 2', $this->title());
    }

    public function testNewAndCreate(){
        $this->url('http://127.0.0.1/trcdrlib/item/new.php');
        $this->assertEquals('New Item', $this->title());
        $this->byId('name')->value('テストのアイテム');
        $this->byId('submit_button')->click();
    }

    public function testEditAndUpdate(){
        #$this->url('http://127.0.0.1/trcdrlib/item/edit.php?id=2');
        #$this->assertEquals('Edit Item 2', $this->title());
        #$this->byId('name')->value('');
        #$this->byId('submit_button')->click();
    }

    public function testDeleteItemFromList(){
        $this->url('http://127.0.0.1/trcdrlib/item');
        #$this->assertEquals('Item List', $this->title());
    }
}
