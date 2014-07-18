<?php
require_once(_TR_LIBPATH."Model.php");
class ItemModel extends Model {
    protected static $tableName = 'items';
    protected static $columnNames = ['name'];
}
