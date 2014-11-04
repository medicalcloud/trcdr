<?php
require_once("ItemController.php");
#$controller = new ItemController();
#$item = $controller->showOne();
global $ITEM;

$linksToEdit = new LinksToEdit();
$linksToShowMany = new LinksToShowMany();
?>
<html>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head><title>Show Item <?php echo($ITEM->id) ?></title></head>
<body>
アイテムID：<?php ph($ITEM->id); ?><br>
アイテム名：<?php ph($ITEM->name); ?><br>
<?php $linksToEdit->p("Edit", $ITEM->id); ?><br>
<?php $linksToShowMany->p("Back"); ?><br>
</body>
</html>

