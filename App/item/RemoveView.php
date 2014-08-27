<?php
require_once("ItemController.php");
$controller = new ItemController();
$controller->remove($_REQUEST["id"]);

