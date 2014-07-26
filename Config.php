<?php
require_once("Pathes.php");

Pathes::setAppPath(__DIR__."/App/");
Pathes::setLibPath(__DIR__."/Lib/");
Pathes::setBaseUrl("http://127.0.0.1/trcdr/");
define("_TR_DSN", 'mysql:host=localhost;dbname=trcdr;charset=utf8');
define("_TR_DB_USERNAME", "username");
define("_TR_DB_PASSWORD", "password");


