<?php
require_once(__DIR__.'/Lib/Bootstrap.php');
Pathes::setAppPath(__DIR__."/App/");
Pathes::setBaseUrl("http://127.0.0.1/trcdrlib/");
Pathes::loadLib('Strict');
DBManager::addDBParams('mysql:host=localhost;dbname=trcdr;charset=utf8',
    "username",
    "password");


