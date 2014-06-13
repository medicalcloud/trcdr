<?php 
require_once("../Config.php");
require_once(_TR_LIBPAHT."Dispatcher.php"); 
$dispatcher = new Dispatcher('item');
$dispatcher->work_as_generic_index();



