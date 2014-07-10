<?php
require_once("ItemModel.php");
require_once(_TR_LIBPATH."Helpers.php");
$item = ItemModel::find_one($_REQUEST['id']);
?>
<html>
<head><title>Show Item <?php echo($_REQUEST['id']) ?></title></head>
<body>
アイテムID：<?php ph($item->id); ?><br>
アイテム名：<?php ph($item->name); ?><br>
<?php link_to_edit("Edit", $item->id); ?><br>
<?php link_to_show_many("Back"); ?><br>
</body>
</html>


