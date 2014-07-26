<?php
Pathes::loadLib("Helpers");
class HelpersTest extends PHPUnit_Framework_TestCase{
    public function testH(){
        $this->assertEquals(h("hogehoge"), "hogehoge");
    }
}
