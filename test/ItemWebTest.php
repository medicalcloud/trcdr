<?php
class WebTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp(){
        $this->setBrowser('firefox');
        $this->setBrowserUrl('http://127.0.0.1/trcdr/');
    }

    public function testTitle(){
        $this->url('http://127.0.0.1/trcdr/');
        #$this->assertEquals('Example WWW Page', $this->title());
    }
}
