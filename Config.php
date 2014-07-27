<?php
require_once("Pathes.php");

Pathes::setAppPath(__DIR__."/App/");
Pathes::setLibPath(__DIR__."/Lib/");
Pathes::setBaseUrl("http://127.0.0.1/trcdr/");

Pathes::loadLib('DBManager');
DBManager::addDBParams('mysql:host=localhost;dbname=trcdr;charset=utf8',
    "username",
    "password");


