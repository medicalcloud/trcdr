<?php namespace trcdr;
Pathes::loadLib("DBManager");
class DBManagerTest extends \PHPUnit_Framework_TestCase{
    private $dbman;
    public function setUp(){
        $this->dbman = new DBManager();
    }

    public function testGetDbh(){
        $dbh = $this->dbman->getDbh();
        $this->assertInstanceOf("PDO", $dbh);
        $this->dbman->closeDbh();
    }
}
