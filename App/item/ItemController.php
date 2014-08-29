<?php
require_once("ItemModel.php");
Pathes::loadLib("Controller");
class ItemController extends Controller{
    protected $modelclass = "ItemModel";
    protected $count_per_page = 10;
    protected $dirname = "item";
}
