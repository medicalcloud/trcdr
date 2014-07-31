<?php
require_once("ItemModel.php");
Pathes::loadLib("Controller");
class ItemController extends Controller{
    protected static $modelclass = "ItemModel";
    protected static $count_per_page = 10;
}
