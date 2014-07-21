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
        $this->byId('link_to_show_4')->click();
        $this->byId('link_to_show_many')->click();
    }

    public function testShow(){
        $this->url('http://127.0.0.1/trcdr/item/index.php?id=2');
        $this->assertEquals('Show Item 2', $this->title());
    }

    public function testNewAndCreate(){
        $this->url('http://127.0.0.1/trcdr/item/new.php');
        $this->assertEquals('New Item', $this->title());
        $this->byId('name')->value('テストのアイテム');
        $this->byId('submit_button')->click();
    }

    public function testEditAndUpdate(){
        $this->url('http://127.0.0.1/trcdr/item/edit.php?id=3');
        $this->assertEquals('Edit Item 3', $this->title());
        $this->byId('name')->value('テストのアップデート');
        $this->byId('submit_button')->click();
    }

    public function testDeleteItemFromList(){
        $this->url('http://127.0.0.1/trcdr/item');
        $this->assertEquals('Item List', $this->title());
    }
}
