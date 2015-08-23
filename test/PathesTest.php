<?php namespace trcdr;
Pathes::loadLib("Pathes");
class PathesTest extends \PHPUnit_Framework_TestCase{
    public function setup(){
    }
    
    public function testAppPath(){
        Pathes::setAppPath("App");
        $this->assertEquals('App', Pathes::getAppPath());
    }

    public function testLibPath(){
        Pathes::setLibPath("Lib/");
        $this->assertEquals('Lib/', Pathes::getLibPath());
    }

    public function testBaseUrl(){
        Pathes::setBaseUrl("http://dev.trcdr.com/trcdr/");
        $this->assertEquals('http://dev.trcdr.com/trcdr/', Pathes::getBaseUrl());
        $this->assertEquals('http://dev.trcdr.com/trcdr/docs/beautiful/girl.html',
            Pathes::buildUrl('docs/beautiful/girl.html'));
    }
}
