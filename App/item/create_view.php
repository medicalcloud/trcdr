<?php
require_once("ItemModel.php");
ItemModel::create($_REQUEST);
var_dump($_REQUEST);
$dispatcher = new Dispatcher('item');
$dispatcher->redirectTo("index.php");



