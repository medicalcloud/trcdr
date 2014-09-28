<?php

require_once('Pathes.php');
class Bootstrap {
    public static function start(){
        Pathes::setLibPath(__DIR__.'/');
        Pathes::loadLib('DBManager');
        Pathes::loadLib('Dispatcher');
    }
}

function strict_error_handler($eNo, $eStr, $eFile, $eLine){
    die("STRICT STOP: {$eNo} {$eStr} {$eFile} {$eLine}".PHP_EOL);
}

function stop_when_error(){
    set_error_handler("string_error_handler");
}

Bootstrap::start();

