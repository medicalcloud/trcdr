<?php
require_once("ItemModel.php");
ItemModel::remove($_REQUEST["id"]);
echo "Yey! remove action is called!";
$dispatcher = new Dispatcher('item');
$dispatcher->redirectTo("index.php");

