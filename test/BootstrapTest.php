<?php
Pathes::loadLib('Bootstrap');

class BootstrapTest extends PHPUnit_Framework_TestCase{
    public function testStart(){
        Bootstrap::start();
    }
}
