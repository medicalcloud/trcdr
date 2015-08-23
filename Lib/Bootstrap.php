<?php namespace trcdr;
require_once('Pathes.php');
class Bootstrap {
    public static function start(){
        Pathes::setLibPath(__DIR__.'/');
        Pathes::loadLib('RbClasses');
        Pathes::loadLib('DBManager');
        Pathes::loadLib('Dispatcher');
    }
}

Bootstrap::start();

