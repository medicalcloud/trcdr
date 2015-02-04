<?php
class ItemWebTest extends PHPUnit_Extensions_Selenium2TestCase
{
/*    protected function setUp(){
        $this->setBrowser('phantomjs');
        $this->setBrowserUrl('http://127.0.0.1/trcdrlib/');
    }

//    public function testIndexAndShow(){
//        $this->url('http://127.0.0.1/trcdrlib/item/');
//        $this->assertEquals('Item List', $this->title());
//        $this->byId('linkToShow0')->click();
//        $this->assertStringStartsWith('Show Item', $this->title());
//        $this->byId('linkToShowMany0')->click();
//    }
 
    public function testNewAndCreate(){
        $this->url('http://127.0.0.1/trcdrlib/item/new.php');
        $this->assertEquals('New Item', $this->title());
        $this->byId('name')->value('テストで作られたアイテム');
        $this->byId('submitButton')->click();
    }

    public function testEditAndUpdate(){
        $this->url('http://127.0.0.1/trcdrlib/item');
        $this->byId('linkToEdit9')->click();
        $this->assertStringStartsWith('Edit Item', $this->title());
        $this->byId('name')->value("updated");
        $this->byId('submitButton')->click();
    }

    public function testDeleteItemFromList(){
        $this->url('http://127.0.0.1/trcdrlib/item');
        $this->assertEquals('Item List', $this->title());
        $this->byId('buttonToRemove8')->click();
    }
*/
}
