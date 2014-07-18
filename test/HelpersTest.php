<?php
require_once(_TR_LIBPATH."Helpers.php");
class HelpersTest extends PHPUnit_Framework_TestCase{
    public function testH(){
        $this->assertEquals(h("hogehoge"), "hogehoge");
    }
}
