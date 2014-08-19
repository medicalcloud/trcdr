<?php
require_once('Pathes.php');
class Bootstrap {
    public static function start(){
        Pathes::setLibPath(__DIR__.'/');
        Pathes::loadLib('DBManager');
        Pathes::loadLib('Dispatcher');
        Pathes::loadLib('Session');
    }
}

Bootstrap::start();

