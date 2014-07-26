<?php
Pathes::loadLib("DBManager");
class DBManagerTest extends PHPUnit_Framework_TestCase{
    private $dbman;
    public function setUp(){
        $this->dbman = new DBManager();
    }

    public function testGetDbh(){
        $this->dbman->getDbh();
    }

    public function testCloseDbh(){
        $this->dbman->closeDbh();
    }

}
