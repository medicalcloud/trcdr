<?php 
require_once("../Config.php");
Pathes::loadLib("Dispatcher"); 
$dispatcher = new Dispatcher('item');
$dispatcher->workAsGenericIndex();



