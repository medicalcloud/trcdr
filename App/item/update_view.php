<?php
require_once("ItemModel.php");
ItemModel::update($_REQUEST);
echo "Yey! update is called!";
var_dump($_REQUEST);
$dispatcher = new Dispatcher("item");
$dispatcher->redirectTo("index.php");

