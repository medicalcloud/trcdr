<?php
require_once("ItemModel.php");
require_once(_TR_LIBPATH."Helpers.php");
$items = ItemModel::find_many();
?>
<html>
<head><title>Item List</title></head>
<body>
<?php 
$table = new Table();
foreach ($items as $item) {
    $table->tr();
    $table->td();
    ph($item->id);
    $table->td_end();
    $table->td();
    link_to_show_one(h($item->name), $item->id);
    $table->td_end();
    $table->td();
    link_to_edit("Edit", $item->id);
    $table->td_end();
    $table->td();
    button_to_remove("Remove", $item->id);
    $table->td_end();
    $table->tr_end();
}
$table->table_end();
link_to_new("New")
?>
</body>
</html>
