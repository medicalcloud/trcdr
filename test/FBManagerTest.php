<?php namespace trcdr;
Pathes::loadLib("FBManager");
class FBManagerTest extends \PHPUnit_Framework_TestCase{
    public function setup(){
    }
    
    public function testAppName(){
        FBManager::setAppName("hoge");
        $this->assertEquals('hoge', FBManager::getAppName());
    }

    public function testAppId(){
        FBManager::setAppId("123456");
        $this->assertEquals('123456', FBManager::getAppId());
    }

    public function testAppSecret(){
        FBManager::setAppSecret("123456");
        $this->assertEquals('123456', FBManager::getAppSecret());
    }
}
