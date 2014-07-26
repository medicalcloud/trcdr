<?php
Pathes::loadLib("Model");
class ItemModel extends Model {
    protected static $tableName = 'items';
    protected static $columnNames = ['name'];
}
