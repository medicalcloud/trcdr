<?php
require_once("../Config.php");
require_once(_TR_LIBPATH."Dispacher.php");
$dispatcher = new Dispatcher('item');
$dispatcher->work_as_generic_edit();

   

