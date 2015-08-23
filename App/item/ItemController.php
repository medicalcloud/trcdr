<?php namespace trcdr;
require_once("ItemModel.php");
Pathes::loadLib("Controller");
class ItemController extends Controller{
    protected $modelName = 'item';
    protected $count_per_page = 10;
}
