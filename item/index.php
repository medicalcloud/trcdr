<?php namespace trcdr; 
require_once("../Config.php");
$dispatcher = new Dispatcher(basename(__DIR__));
$dispatcher->dispatchAsGenericIndex();



