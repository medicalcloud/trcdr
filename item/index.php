<?php 
require_once("../Config.php");
require_once(_TR_LIBPATH."Dispatcher.php"); 
$dispatcher = new Dispatcher('item');
$dispatcher->workAsGenericIndex();



